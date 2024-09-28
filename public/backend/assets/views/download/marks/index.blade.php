@extends('layouts.app')

@section('title', 'Filtrer les Notes')

@section('content')
    <style>
        ::placeholder {
            color: #ffffff !important;
            opacity: 1;
        }
    </style>

    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin">
                    <div class="container">
                        <div class="card p-4 shadow-sm pt-5">
                            <h3 class="card-title text-center mb-4">Filtrer les Notes</h3>
                            <form class="forms-sample" action="{{ route('downloads.filter_marks') }}" method="GET" enctype="multipart/form-data" style="width: 80%; margin: 0 auto;">
                                @csrf
                                <div class="row flex-row flex-wrap">
                                    <h5 class="card-title text-left mb-4">Filter Documents</h5>
                                    <div class="col-md-4 mb-3">
                                        <select class="form-control" id="year" name="year" style="color: #ffffffaa;" required>
                                            <option value="" disabled selected>Année</option>
                                            @for ($year = 2010; $year <= now()->year; $year++)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <select class="form-control" id="sequence" name="sequence" style="color: #ffffffaa;" required>
                                            <option value="" disabled selected>Séquence</option>
                                            <option value="1st">1ère</option>
                                            <option value="2nd">2ème</option>
                                            <option value="3rd">3ème</option>
                                            <option value="4th">4ème</option>
                                            <option value="5th">5ème</option>
                                            <option value="6th">6ème</option>
                                        </select>
                                    </div>
                                    {{-- <div class="col-md-4 mb-3">
                                        <select class="form-control" id="subject" name="subject" style="color: #ffffffaa;" required>
                                            <option value="" disabled selected>Matière</option>
                                            <option value="Mathematics">Mathématiques</option>
                                            <option value="English">Anglais</option>
                                            <option value="Physics">Physique</option>
                                            <option value="Chemistry">Chimie</option>
                                            <option value="Biology">Biologie</option>
                                        </select>
                                    </div> --}}
                                </div>
                                <div class="text-center mt-3 mb-4">
                                    <button type="submit" class="btn btn-inverse-success btn-lg w-100 mt-3 mb-4">Rechercher</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
