
@extends('layouts.app')

@section('title', 'Profile')

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
            <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
            <p class="text-muted">{{ $user->contact}}</p>
            </div>
            <div class="mt-3">
            <label class="tx-11 fw-bolder mb-0 text-uppercase">School:</label>
            <p class="text-muted">{{ $user->school}}</p>
            </div>
            <div class="mt-3 d-flex social-links">
            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                <i data-feather="github"></i>
            </a>
            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                <i data-feather="twitter"></i>
            </a>
            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                <i data-feather="instagram"></i>
            </a>
            </div>
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
                        <h6 class="card-title">UPDATE PROFILE</h6>
                        <form class="forms-sample" action="{{ route('profile.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class=" row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class=" row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" autocomplete="off" value="{{ $user->email }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact" autocomplete="off" value="{{ $user->contact }}">
                                </div>
                            </div>
                            <div class=" row mb-3">
                                <div class="col-md-6">
                                    <label for="school" class="form-label">School</label>
                                    <input type="text" class="form-control" id="school" name="school" autocomplete="off" value="{{ $user->school }}" readonly>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="photo">Upload Image</label>
                                    <input class="form-control" type="file" id="photo" name="photo">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"> </label>
                                <img id="showImage" class="wd-70 rounded-circle m-2" src="{{ (!empty($user->photo) ? url('upload/profiles/'.$user->photo) : url('upload/no_image.jpg'))}}" alt="profile">
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

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#photo').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection

