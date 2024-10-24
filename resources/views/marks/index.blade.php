@extends('layouts.app')

@section('title', 'Marks List')

@section('content')

    <div class="container">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <h5 class="mb-0">LIST OF ALL MARKS</h5>
                <a class="btn btn-success" href="{{ route('marks.create') }}">
                    <i class="mdi mdi-plus-circle"></i> Add New Marks
                </a>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('marks.index') }}" class="mb-4">
                    {{-- <h6 class="mb-3">Filter Marks</h6> --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="class_id" class="form-label">Class</label>
                            <select name="class_id" id="class_id" class="form-select">
                                <option value="">All Classes</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sequence" class="form-label">Evaluation</label>
                            <select name="sequence" id="sequence" class="form-select">
                                <option value="">All Evaluations</option>
                                @foreach ([1, 2, 3, 4, 5, 6] as $seq)
                                    <option value="{{ $seq }}" {{ request('sequence') == $seq ? 'selected' : '' }}>
                                        Evaluation {{ $seq }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Filter Marks</button>
                        @if (request('class_id') && request('sequence'))
                            <a target="_blank" href="{{ route('master.sheet.download', ['class_id' => request('class_id'), 'sequence' => request('sequence')]) }}"
                               class="btn btn-warning">Download Master Sheet</a>
                        @endif
                    </div>

                </form>

                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Evaluation</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($marks as $mark)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mark['classe'] ? $mark['classe']->name : 'N/A' }}</td>
                                    <td>{{ $mark['subject']->name }}</td>
                                    <td>{{ $mark['sequence'] }}</td>
                                    <td>
                                        @if ($mark['filled'])
                                            <span class="text-success">✔️</span> <!-- Green check -->
                                        @else
                                            <span class="text-danger">❌</span> <!-- Red cross -->
                                        @endif
                                    </td>
                                    <td>
                                        @if ($mark['mark'])
                                            <a href="{{ route('marks.view', ['classe_id' => $mark['classe']->id, 'subject_id' => $mark['subject']->id, 'sequence' => $mark['sequence']]) }}"
                                                class="btn btn-info btn-sm">View</a>
                                            <a target="_blank"
                                                href="{{ route('marks.download', ['classe_id' => $mark['classe']->id, 'subject_id' => $mark['subject']->id, 'sequence' => $mark['sequence']]) }}"
                                                class="btn btn-info btn-sm">Download</a>
                                        @else
                                            <span class="text-muted">No mark available</span>
                                        @endif

                                        @if ($mark['mark'])
                                            <form
                                                action="{{ route('marks.delete', ['classe_id' => $mark['classe']->id, 'subject_id' => $mark['subject']->id, 'sequence' => $mark['sequence']]) }}"
                                                method="POST" class="d-inline" onsubmit="return confirmDelete();">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-danger">
                                        <strong>No Marks Found</strong>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                <div class="mt-3">
                    {{-- {{ $marks->links('pagination::bootstrap-4') }} --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this mark? This action cannot be undone.');
        }
    </script>

@endsection
