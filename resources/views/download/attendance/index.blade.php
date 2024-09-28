@extends('layouts.app')

@section('title', 'Filtrer la Présence')

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
                            <h3 class="card-title text-center mb-4">Download Attendance Sheets</h3>
                            <form class="forms-sample" action="{{ route('downloads.filter_attendance') }}" method="GET" style="width: 90%; margin: 0 auto;">
                                @csrf
                                <div class="row flex-row flex-wrap">
                                    <h5 class="card-title text-left mb-4">Filter Documents</h5>
                                    {{-- <div class="col-md-3 mb-3">
                                        <select class="form-control" id="jour" name="jour" style="color: #ffffffaa;">
                                            <option value="" disabled selected>Jour</option>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div> --}}
                                    <div class="col-md-4 mb-3">
                                        <select class="form-control" id="mois" name="mois" style="color: #ffffffaa;">
                                            <option value="" disabled selected>Mois</option>
                                            <option value="1">Janvier</option>
                                            <option value="2">Février</option>
                                            <option value="3">Mars</option>
                                            <option value="4">Avril</option>
                                            <option value="5">Mai</option>
                                            <option value="6">Juin</option>
                                            <option value="7">Juillet</option>
                                            <option value="8">Août</option>
                                            <option value="9">Septembre</option>
                                            <option value="10">Octobre</option>
                                            <option value="11">Novembre</option>
                                            <option value="12">Décembre</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <select class="form-control" id="annee" name="annee" style="color: #ffffffaa;">
                                            <option value="" disabled selected>Année</option>
                                            @for ($year = 2010; $year <= now()->year; $year++)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
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
                                    {{-- <div class="col-md-3 mb-3">
                                        <select class="form-control" id="etudiant" name="etudiant" style="color: #ffffffaa;">
                                            <option value="" disabled selected>Étudiant</option>
                                            <option value="1">Étudiant A</option>
                                            <option value="2">Étudiant B</option>
                                            <option value="3">Étudiant C</option>
                                            <option value="4">Étudiant D</option>
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

