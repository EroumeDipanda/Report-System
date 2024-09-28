@extends('layouts.app')

@section('title', 'Report Cards')

@section('content')
    <div class="col-md-8 col-xl-12 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">GENERATE REPORT CARDS</h5>
                        <form action="{{ route('reports.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="classe">Select Class:</label>
                                <select name="classe_id" id="classe" class="form-control" required>
                                    <option selected>Select Classe</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="term">Select Term:</label>
                                <select name="term" id="term" class="form-control" required>
                                    <option selected>Select Term</option>
                                    <option value="1">FIRST TERM</option>
                                    <option value="2">SECOND TERM</option>
                                    <option value="3">THIRD TERM</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-fw p-2 btn-success">GENERATE REPORTS
                                </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($reports) && $reports->isNotEmpty())
            <div class="row mt-4">
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">GENERATED REPORTS</h5>
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Class</th>
                                        <th>Term</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $key => $report)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{ $report->classe->name }}</td>
                                            <td>{{ $report->term }}</td>
                                            <td>
                                                <a target="_blank" href="{{ route('reports.download', $report->id) }}" class="btn btn-primary">
                                                    Download Report
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

@endsection
