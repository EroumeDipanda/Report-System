@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if ($logs->count() > 0)
                            <div class="text-end mt-3 mb-3">
                                <form action="{{ route('activity-logs.delete') }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete all logs?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn p-2 btn-danger">
                                        Delete All Logs
                                    </button>
                                </form>
                            </div>
                        @endif
                        <h3 class="card-title">ACTIVITY LOGS</h3>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>DESCRIPTION</th>
                                        <th>LOGGED AT</th>
                                        <th>SUBJECTS</th>
                                        <th>CAUSER</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logs as $key => $log)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->created_at->format('d M Y, H:i') }}</td>
                                            <td>
                                                @if ($log->subject)
                                                    {{ class_basename($log->subject_type) }}
                                                    (ID: {{ $log->subject_id }})
                                                    @if ($log->subject->name ?? $log->subject->title)
                                                        {{ $log->subject->name ?? $log->subject->title }}
                                                    @else
                                                        {{-- {{ $log->subject->email ?? 'N/A' }} --}}
                                                    @endif
                                                    <br><br>
                                                    School: {{ $log->subject->school->name ?? 'GENS' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if ($log->causer)
                                                    {{ $log->causer->name ?? 'N/A' }}
                                                    ({{ class_basename($log->causer_type) }} - ID: {{ $log->causer_id }})
                                                    <br><br>
                                                    School: {{ $log->causer->school->name ?? 'GENS' }}
                                                @else
                                                    System
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('activity-logs.deleteById', $log->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this log?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="6" class="text-info text-center">
                                            <h5>NO LOGS FOUND</h5>
                                        </td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
