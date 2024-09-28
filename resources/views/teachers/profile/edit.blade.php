@extends('layouts.app')

@section('title', 'Profile')

@section('content')

    <div class="page-content">

        <div class="row profile-body">
            <!-- Left Sidebar -->
            <div class="col-md-4 d-none d-md-block">
                <div class="card shadow-sm rounded">
                    <div class="card-body text-center">
                        <img class="wd-100 rounded-circle mb-3"
                            src="{{ !empty($user->photo) ? url('upload/profiles/' . $user->photo) : url('upload/no_image.jpg') }}"
                            alt="profile">
                        <h4 class="card-title mb-2">{{ $user->name }}</h4>
                        <p class="text-muted mb-1">{{ $user->email }}</p>
                    </div>
                    <div class="card-footer text-center">
                        @if ($user->school)
                            <p class="text-muted mb-0">Etablissement: {{ $user->school->name }}</p>
                        @else
                            <p class="text-muted mb-0">Etablissement: GENS</p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- End Left Sidebar -->

            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-4">MODIFIER LE PROFILE</h5>
                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Noms</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}" required>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $user->email }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="contact" class="form-label">Contact</label>
                                            <input type="text" class="form-control" id="contact" name="contact"
                                                value="{{ $user->contact }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="username" class="form-label">Noms d'utilisateur</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="{{ $user->username }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="photo" class="form-label">Charger une Image</label>
                                            <input type="file" class="form-control" id="photo" name="photo">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-fw p-2 btn-success">Enregistrer
                                        Modifications</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- middle wrapper end -->
            <!-- right wrapper start -->

            <!-- right wrapper end -->
        </div>

    </div>
@endsection
