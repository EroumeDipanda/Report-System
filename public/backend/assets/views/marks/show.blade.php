@extends('layouts.app')

@section('title', __('messages.marks.title_show'))

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3>{{ __('messages.classes.view_content_title') }}</h3>

                    <div class="row mt-3 mb-3">
                        <div class="col-12 d-flex flex-column flex-md-row justify-content-between">
                            <!-- File Information -->
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h6>{{ __('messages.classes.file_name') }}: {{ $upload->file_name }}</h6>
                                <p>{{ __('messages.classes.uploaded_at') }}
                                    {{ \Carbon\Carbon::parse($upload->uploaded_at)->format('l, F j, Y g:i A') }}</p>
                                @if ($upload->status == 'exported')
                                    <p>{{ __('messages.classes.exported_at') }} {{ $upload->exported_at }}</p>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div
                                class="col-md-6 d-flex flex-wrap justify-content-end align-items-center text-center text-md-end">
                                @if (Auth::user()->is_admin)
                                    @if ($upload->status == 'pending')
                                        <form id="process-form" action="{{ route('marks.process', $upload->id) }}"
                                            method="POST" class="mb-2 me-2 mb-md-0">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-success d-inline-flex align-items-center"
                                                onclick="showProcessing()">
                                                Traiter &nbsp;<i class="mdi mdi-progress-check mdi-24px"></i>
                                            </button>
                                        </form>
                                    @elseif ($upload->status == 'processed')
                                        <a href="{{ route('marks.viewProcessed', $upload->id) }}"
                                            class="btn btn-success d-inline-flex align-items-center mb-2 mb-md-0">
                                            Ficher Traite &nbsp;<i class="mdi mdi-folder mdi-24px"></i>
                                        </a>
                                    @endif

                                    <!-- Processing Indicator -->
                                    <div id="processing-indicator"
                                        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; text-align: center; justify-content: center; align-items: center; z-index: 9999; font-size: 1.5rem;">
                                        <div
                                            style="display: inline-flex; flex-direction: column; align-items: center; justify-content: center; height: 100%;">
                                            <i class="mdi mdi-loading mdi-50px mdi-spin"
                                                style="font-size: 5rem; color: #007bff;"></i>
                                            <p style="font-size: 2rem; font-weight: bold; margin-top: 10px;">Processing...
                                            </p>
                                        </div>
                                    </div>

                                    @if ($upload->status === 'pending')
                                        <form action="{{ route('marks.reject', $upload->id) }}" method="POST"
                                            class="mb-2 mb-md-0 ms-0 ms-md-2">
                                            @csrf
                                            <input type="hidden" name="status">
                                            <button type="submit"
                                                class="btn btn-danger d-inline-flex align-items-center">
                                                {{ __('messages.classes.reject') }} &nbsp;<i
                                                    class="mdi mdi-close-circle mdi-24px"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                &nbsp;
                                <a href="{{ route('marks.download', $upload->id) }}"
                                    class="btn btn-primary d-inline-flex align-items-center">
                                    {{ __('messages.classes.download_button') }} &nbsp;<i
                                        class="mdi mdi-download mdi-24px"></i>
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
                                        <td colspan="7" class="text-center">{{ __('messages.marks.table_no_data') }}
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
@endsection

@section('script')
    <script>
        function showProcessing() {
            document.getElementById('processing-indicator').style.display = 'flex';
        }

        // Ensure the indicator is hidden by default
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('processing-indicator').style.display = 'none';
        });
    </script>
@endsection
