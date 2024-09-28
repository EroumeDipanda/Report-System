@extends('layouts.app')

@section('title', __('messages.classes.import_classes_title'))

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="text-end mb-3">
                        @if (Auth::user()->role == 'user')
                            <a class="btn btn-success d-inline-flex align-items-center"
                                href="{{ route('classes.create') }}">
                                {{ __('messages.classes.upload_file_button') }} <i
                                    class=" ms-2 mdi mdi-plus-circle mdi-24px"></i>
                            </a>
                        @endif
                    </div>
                    <h3 class="card-title">{{ __('messages.classes.list_of_files_title') }}</h3>
                    @if (Auth::user()->role == 'super_admin')
                        <div class="row mt-3 mb-3">
                            <div class="col-md-12 col-sm-6 justify-content-end">
                                <style>
                                    .btn-custom-size {
                                        height: 100%;
                                        line-height: 1.5;
                                        /* Adjust if needed */
                                        padding: .375rem .75rem;
                                        /* Adjust padding to match input fields */
                                    }
                                </style>

                                <form action="{{ route('classes.search') }}" method="GET">
                                    @csrf
                                    <div class="row align-items-end">
                                        <div class="col-md col-sm-6 mb-2">
                                            <input type="text" class="form-control"
                                                placeholder="{{ __('messages.navbar.search_placeholder') }}" id="name"
                                                name="name" value="{{ old('name', request()->input('name')) }}">
                                        </div>
                                        <div class="col-md col-sm-6 mb-2">
                                            <select class="form-select" name="school_id" aria-placeholder="Search School">
                                                <option value="">{{ __('messages.staff.form.school') }}
                                                </option>
                                                @foreach ($schools as $school)
                                                    <option value="{{ $school->id }}"
                                                        {{ old('school_id', request()->input('school_id')) == $school->id ? 'selected' : '' }}>
                                                        {{ $school->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md col-sm-6 mb-2">
                                            <input type="date" class="form-control" id="date" name="date"
                                                value="{{ old('date', request()->input('date')) }}">
                                        </div>
                                        <div class="col-md-auto d-flex align-items-end">
                                            <button type="submit"
                                                class="btn btn-success btn-custom-size d-flex align-items-center justify-content-center">
                                                <i class="mdi mdi-magnify" style="font-size: 1.rem;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>{{ __('messages.classes.file_name') }}</th>
                                    @if (Auth::user()->role != 'user')
                                        <th>{{ __('messages.classes.school') }}</th>
                                    @endif
                                    <th class="text-center">{{ __('messages.classes.date') }}</th>
                                    <th>{{ __('messages.classes.status') }}</th>
                                    <th class="text-center">{{ __('messages.classes.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($uploads as $upload)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $upload->file_name }}</td>
                                        @if (Auth::user()->role != 'user')
                                            <td>{{ $upload->school->name }}</td>
                                        @endif
                                        <td>{{ \Carbon\Carbon::parse($upload->uploaded_at)->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td>
                                            @if ($upload->status == 'pending')
                                                <span
                                                    class="btn btn-sm btn-warning btn-rounded">{{ __('messages.classes.pending') }}</span>
                                            @elseif ($upload->status == 'processed')
                                                <span
                                                    class="btn btn-sm btn-success btn-rounded">{{ __('messages.classes.accepted') }}</span>
                                            @elseif ($upload->status == 'rejected')
                                                <span
                                                    class="btn btn-sm btn-danger btn-rounded">{{ __('messages.classes.rejected') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('classes.show', $upload) }}"
                                                class="btn btn-success">{{ __('messages.classes.view_button') }}</a>
                                            <form action="{{ route('upload.delete', $upload->id) }}" method="POST"
                                                style="display:inline;" onsubmit="return confirmDelete();">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    {{ __('messages.classes.delete_button') }}
                                                </button>
                                            </form>

                                            <script>
                                                function confirmDelete() {
                                                    // Display a confirmation dialog
                                                    return confirm('{{ __('messages.classes.confirm_delete') }}');
                                                }
                                            </script>

                                        </td>
                                    </tr>
                                @empty
                                    @if (Auth::user()->role != 'user')
                                        <td colspan="6" class="text-info text-center">
                                            <h5>{{ __('messages.classes.no_data_found') }}</h5>
                                        </td>
                                    @else
                                        <td colspan="5" class="text-info text-center">
                                            <h5>{{ __('messages.classes.no_data_found') }}</h5>
                                        </td>
                                    @endif
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
