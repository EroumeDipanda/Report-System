@extends('layouts.app')

@section('title', 'Change Password')

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
                                <h5 class="card-title">MODIFIER LE MOT DE PASSE</h5>
                                <form class="forms-sample" action="{{ route('password.update') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="old_password" class="form-label">Current Password</label>
                                        <input type="password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            id="old_password" name="old_password" autocomplete="off"
                                            placeholder="Enter Current Password">
                                        @error('old_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">New Password</label>
                                        <input type="password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            id="new_password" name="new_password" autocomplete="off"
                                            placeholder="Enter New Password">
                                        @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="new_password_confirmation" autocomplete="off"
                                            placeholder="Confirm Password">
                                    </div>

                                    <button type="submit" class="btn btn-fw btn-success p-2">Enregister Modification</button>
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
