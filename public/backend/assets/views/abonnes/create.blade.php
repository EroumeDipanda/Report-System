@extends('layouts.app')

@section('title', 'Telecharger')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="col-md-12 grid-margin">
                <div class="container">
                    <div class="card p-4 shadow-sm pt-5">
                        <h3 class="card-title text-center mb-4">INFORMATIONS ABONNEES</h3>
                        <form class="forms-sample" action="{{ route('abonnes.export') }}" method="POST"
                            enctype="multipart/form-data" style="width: 80%; margin: 0 auto;">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Type d'abonees</label>
                                    <select class="form-select" name="type">
                                        <option selected>Choisir le type d'abonnees</option>
                                        <option value="teachers">Enseignants</option>
                                        <option value="parents">Parents</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3 pb-3">
                                <div class="col-md-12">
                                    <label class="form-label">{{ __('messages.staff.form.school') }}</label>
                                    <select class="form-select" name="school_id">
                                        <option selected>{{ __('messages.staff.form.school') }}</option>
                                        @foreach ($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-center mt-3 mb-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100">Telecharger</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
