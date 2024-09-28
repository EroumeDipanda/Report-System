@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3>PARENTS FILE CONTENT</h3>

                    <div class="row mt-3 mb-3">
                        <div class="col-12 d-flex flex-column flex-md-row justify-content-between">
                            <!-- File Information -->
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h6>{{ __('messages.classes.file_name') }}: {{ $upload->file_name }}</h6>
                            </div>

                            <!-- Action Buttons -->
                            <div
                                class="col-md-6 d-flex flex-wrap justify-content-end align-items-center text-center text-md-end">
                                <a href="#"
                                    class="btn btn-success d-inline-flex align-items-center mb-2 mb-md-0">
                                    Export to DB &nbsp;<i class="mdi mdi-file-export mdi-24px"></i>
                                </a>
                                &nbsp;
                                <a href="{{ route('students.parents.download', ['fileId' => $upload->id]) }}"
                                    class="btn btn-info d-inline-flex align-items-center mb-2 mb-md-0 ms-0 ms-md-2">
                                    Download Parents &nbsp;<i class="mdi mdi-download mdi-24px"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Error Message -->
                        @if (isset($errorData) && $errorData)
                            <div class="alert alert-danger d-flex align-items-center mt-3" role="alert"
                                style="width: 100%;">
                                <i class="mdi mdi-alert-circle" style="font-size: 1.5rem; margin-right: 10px;"></i>
                                <p class="mb-0" style="font-weight: bold;">{{ $errorData }}</p>
                            </div>
                        @endif
                    </div>


                    <div class="table-responsive" style="height: 55vh; overflow-auto;">
                        <table class="table table-bordered">
                            <tbody>
                                @forelse($fileData as $row)
                                    <tr>
                                        @foreach ($row as $cell)
                                            <td>{{ $cell }}</td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            {{ __('messages.parents.no_data_available') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
