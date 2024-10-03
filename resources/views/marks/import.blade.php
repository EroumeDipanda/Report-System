@extends('layouts.app')

@section('title', 'Import Marks')

{{-- @section('content')
    <div class="col-md-8 col-xl-8 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">IMPORT MARKS</h5>
                        <form action="{{ route('marks.import.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload Marks File</label>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>
                            <button type="submit" class="btn btn-fw p-2 btn-success">Import Marks</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection --}}

@section('content')
<div class="col-md-8 col-xl-8 middle-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">IMPORT MARKS</h5>
                    <form action="{{ route('marks.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload Marks File</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>

                        <!-- Hidden inputs to store parameters -->
                        <input type="hidden" name="classe_id" value="{{ $classeId }}">
                        <input type="hidden" name="subject_id" value="{{ $subjectId }}">
                        <input type="hidden" name="sequence" value="{{ $sequence }}">

                        <button type="submit" class="btn btn-fw p-2 btn-success">Import Marks</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

