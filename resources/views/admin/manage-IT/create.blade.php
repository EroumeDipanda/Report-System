@extends('layouts.app')

@section('title', __('messages.staff.register_title'))

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin">
                    <div class="container">
                        <div class="card p-4 shadow-sm pt-5">
                            <h3 class="card-title text-center mb-4">{{ __('messages.staff.register_title') }}</h3>
                            <form class="forms-sample" action="{{ route('user.store') }}" method="POST"
                                enctype="multipart/form-data" style="width: 80%; margin: 0 auto;">
                                @csrf 
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('messages.staff.form.name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="{{ __('messages.staff.form.placeholders.name') }}">
                                    @if ($errors->has('name'))
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="username"
                                            class="form-label">{{ __('messages.staff.form.email') }}</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="{{ __('messages.staff.form.placeholders.email') }}">
                                        @if ($errors->has('username'))
                                            <p class="text-danger">{{ $errors->first('username') }}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Entrez l'addresse Email">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('messages.staff.form.school') }}</label>
                                        <select class="form-select" name="school_id">
                                            <option selected>{{ __('messages.staff.form.school') }}</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('school_id'))
                                            <p class="text-danger">{{ $errors->first('school_id') }}</p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact"
                                            class="form-label">{{ __('messages.staff.form.phone') }}</label>
                                        <input type="tel" class="form-control" id="contact" name="contact"
                                            placeholder="{{ __('messages.staff.form.placeholders.phone') }}">
                                    </div>
                                </div>
                                <div class="row mb-3 d-flex">
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label"
                                            for="photo">{{ __('messages.staff.form.photo') }}</label>
                                        <input class="form-control" type="file" id="photo" name="photo">
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <label for="password"
                                            class="form-label">{{ __('messages.staff.form.password') }}</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="{{ __('messages.staff.form.placeholders.password') }}">
                                        @if ($errors->has('password'))
                                            <p class="text-danger">{{ $errors->first('password') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-center mt-3 mb-4">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg w-100">{{ __('messages.staff.create_button') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#photo').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection
