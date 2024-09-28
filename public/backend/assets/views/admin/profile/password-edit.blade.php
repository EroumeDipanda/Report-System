@extends('layouts.app')

@section('title','Change Password')

@section('content')

<div class="page-content">

    <div class="row profile-body">
    <!-- left wrapper start -->
    <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
        <div class="card rounded">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
            <div>
                <img class="wd-70 rounded-circle" src="{{ (!empty($user->photo) ? url('upload/profiles/'.$user->photo) : url('upload/no_image.jpg'))}}" alt="profile">
            </div>

            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
                <p class="text-muted">{{ $user->name}}</p>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                <p class="text-muted">{{ $user->email}}</p>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Contact:</label>
                <p class="text-muted">{{ $user->contact}}</p>
            </div>
            <div class="mt-3 mb-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">School:</label>
                <p class="text-muted">{{ $user->school}}</p>
            </div>
            {{-- <div class="mt-3 d-flex social-links">
                <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                    <i data-feather="github"></i>
                </a>
                <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                    <i data-feather="twitter"></i>
                </a>
                <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                    <i data-feather="instagram"></i>
                </a>
            </div> --}}
        </div>
        </div>
    </div>
    <!-- left wrapper end -->
    <!-- middle wrapper start -->
    <div class="col-md-8 col-xl-8 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">CHANGE PASSWORD</h6>
                        <form class="forms-sample" action="{{ route('password.update')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" autocomplete="off" placeholder="Enter Current Password">
                                @error('old_password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" autocomplete="off" placeholder="Enter New Password">
                                @error('new_password')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="new_password_confirmation" autocomplete="off" placeholder="Confirm Password">
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Save Changes</button>
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
