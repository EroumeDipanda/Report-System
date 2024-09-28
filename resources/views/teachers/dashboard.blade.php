@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h4 class="mb-0">{{$myPendingFiles}} Ficher(s)</h4>
                                {{-- <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p> --}}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success ">
                                <i class="mdi mdi-file-document-box mdi-24px"></i>
                            </div>
                        </div>
                    </div>
                    <h5 class=" text-muted font-weight-normal mt-2">FICHERS EN ATTENTE</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h4 class="mb-0">{{$myRejectedFiles}} Ficher(s)</h4>
                                {{-- <p class="text-success ms-2 mb-0 font-weight-medium">+11%</p> --}}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-danger">
                                <span class="mdi mdi-close-circle-outline icon-item mdi-24px"></span>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-2">FICHERS REJETE</h5>
                </div>
            </div>
        </div>
        {{-- <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">$12.34</h3>
                                <p class="text-danger ms-2 mb-0 font-weight-medium">-2.4%</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-danger">
                                <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Daily Income</h6>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">$31.53</h3>
                                <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Expense current</h6>
                </div>
            </div>
        </div> --}}
    </div>

    {{-- <div id="snackbar" class="snackbar alert alert-danger alert-dismissible fade show" role="alert">
        A file has been rejected.
        <button type="button" class="btn-close" aria-label="Close" onclick="closeSnackbar()"></button>
    </div>     --}}

@endsection

{{-- @section('scripts')
    <style>
        .snackbar {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            min-width: 250px;
        }
    </style>

    <script>
        function closeSnackbar() {
            var snackbar = document.getElementById("snackbar");
            snackbar.classList.remove('show');
            snackbar.classList.add('fade');
        }

        // Automatically hide the snackbar after a certain time (e.g., 10 seconds)
        setTimeout(function() {
            closeSnackbar();
        }, 10000); // 10,000 milliseconds = 10 seconds
    </script>
@endsection --}}
