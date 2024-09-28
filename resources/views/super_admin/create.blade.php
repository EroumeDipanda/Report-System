@extends('layouts.app')

@section('title', 'Creer un administrateur')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="col-md-12 grid-margin">
                <div class="container">
                    <div class="card p-4 shadow-sm pt-5">
                        <h3 class="card-title text-center mb-4">CREER UN ADMINISTRATEUR</h3>
                        <form class="forms-sample" action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data" style="width: 80%; margin: 0 auto;">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('messages.staff.form.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('messages.staff.form.placeholders.name') }}">
                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">{{ __('messages.staff.form.email') }}</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="{{ __('messages.staff.form.placeholders.email') }}">
                                    @if ($errors->has('username'))
                                        <p class="text-danger">{{ $errors->first('username') }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez l'addresse Email">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Attribuer des Établissements</label>
                                    <div class="row">
                                        @foreach ($schools as $school)
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="school{{ $school->id }}" name="schools[]" value="{{ $school->id }}">
                                                    <label class="form-check-label" for="school{{ $school->id }}">
                                                        {{ $school->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 d-flex">
                                <div class="col-md-6 mb-1">
                                    <label for="contact" class="form-label">{{ __('messages.staff.form.phone') }}</label>
                                    <input type="tel" class="form-control" id="contact" name="contact" placeholder="{{ __('messages.staff.form.placeholders.phone') }}">
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="photo">{{ __('messages.staff.form.photo') }}</label>
                                    <input class="form-control" type="file" id="photo" name="photo">
                                </div>
                                {{-- <div class="col-md-6 mb-1">
                                    <label for="password" class="form-label">{{ __('messages.staff.form.password') }}</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('messages.staff.form.placeholders.password') }}">
                                    @if ($errors->has('password'))
                                        <p class="text-danger">{{ $errors->first('password') }}</p>
                                    @endif
                                </div> --}}
                            </div>

                            <div class="text-center mt-3 mb-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100">{{ __('messages.staff.create_button') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

