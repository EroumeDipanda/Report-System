@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h6 class="mb-0">{{ $pendingFilesCount }} Ficher(s)</h6>
                                {{-- <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p> --}}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success ">
                                <i class="mdi mdi-file-document-box mdi-24px"></i>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-2">FICHERS EN ATTENTE</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h6 class="mb-0">{{ $processedFilesCount }} Ficher(s)</h6>
                                {{-- <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p> --}}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success ">
                                <i class="mdi mdi-progress-check mdi-24px"></i>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-2">FICHERS TRAITES</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h6 class="mb-0">{{ $rejectedFilesCount }} Ficher(s)</h6>
                                {{-- <p class="text-success ms-2 mb-0 font-weight-medium">+3.5%</p> --}}
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-danger ">
                                <i class="mdi mdi-close-circle mdi-24px"></i>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-2">FICHERS REJETES</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="d-flex align-items-center align-self-start">
                                <h6 class="mb-0">{{ $schoolCount }} Etablissements</h6>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="icon icon-box-success ">
                                <i class="mdi mdi-file-document-box mdi-24px"></i>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-muted font-weight-normal mt-2">ETABLISSEMENTS</h5>
                </div>
            </div>
        </div>
    </div>

@endsection
