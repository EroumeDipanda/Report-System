@extends('layouts.app')

@section('title', 'View Marks')

@section('content')

<!-- Begin container for page content -->
<div class="container-fluid">
    <!-- Row for main content -->
    <div class="row">
        <!-- Main column with stretch-card -->
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <!-- Card title -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="card-title mb-0">CONTENT OF MARKS</h3>
                        {{-- <a target="_blank" href="{{ route('marks.download', ['id' => $classe->id, 'subject_id' => $subject->id, 'sequence' => $sequence]) }}" class="btn btn-primary">Download Marks PDF</a> --}}
                        <a target="_blank" href="{{ route('marks.download', ['id' => $classe->id, 'sequence' => $sequence]) }}" class="btn btn-primary">Download Marks PDF</a>
                    </div>

                    <!-- Row for class, subject, and evaluation details -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="alert alert-info" role="alert">
                                <h5 class="mb-0"><strong>Class:</strong> {{ $classe->name }}</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-info" role="alert">
                                <h5 class="mb-0"><strong>Subject:</strong> {{ $subject->name }}</h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-info" role="alert">
                                <h5 class="mb-0"><strong>Evaluation:</strong> {{ $sequence }}</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Table to display marks -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Matricule</th>
                                    <th>Student</th>
                                    <th>Mark</th>
                                    <th>Appreciation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($marks as $key => $mark)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $mark->student->matricule }}</td>
                                        <td>{{ $mark->student->first_name }} {{ $mark->student->last_name }}</td>
                                        <td>{{ $mark->mark }}</td>
                                        <td>{{ $mark->appreciation }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h5 class="text-info mb-0">No marks found for this class and subject</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End container -->


@endsection
