@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3>{{ __('messages.classes.processed_file_title') }}</h3>

                    <div class="row mt-3 mb-3">
                        <div class="col-12 d-flex flex-column flex-md-row justify-content-between">
                            <!-- File Information -->
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h6>{{ __('messages.classes.file_name') }}: {{ $upload->file_name }}</h6>
                                @if ($upload->status == 'processed')
                                    <p>{{ __('messages.classes.processed_at') }}:
                                        {{ \Carbon\Carbon::parse($upload->updated_at)->format('l, F j, Y g:i A') }}</p>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div
                                class="col-md-6 d-flex flex-wrap justify-content-end align-items-center text-center text-md-end">
                                @if (Auth::user()->role != 'user')
                                    <!-- Export to DB Button -->
                                    <a href=""
                                        class="btn btn-success d-inline-flex align-items-center mb-2 mb-md-0 me-2">
                                        Export to DB &nbsp;<i class="mdi mdi-file-export mdi-24px"></i>
                                    </a>

                                    <!-- Download Button -->
                                    <a href="{{ route('marks.proccess.download', ['fileId' => $upload->id, 'accepted' => true]) }}"
                                        class="btn btn-primary d-inline-flex align-items-center mb-2 mb-md-0">
                                        {{ __('messages.classes.download_button') }} &nbsp;<i
                                            class="mdi mdi-download mdi-24px"></i>
                                    </a>
                                @endif
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


                    <div class="table-responsive" style="height: 60vh; overflow-auto;">
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
                                            {{ __('messages.classes.no_data_available') }}</td>
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
