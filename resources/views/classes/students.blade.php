@extends('layouts.app')

@section('title', 'All students')

@section('content')

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-5">
                        <h3 class="card-title">LIST OF STUDENTS IN {{ $class->name }}</h3>

                    </div>
                    <div class="col-md-7 text-end">
                            <a target="_blank" href="{{ route('students.id', $class->id) }}"class="btn btn-success"><i
                                    class="mdi mdi-file-document-box"></i>Download School IDs</a>
                        <a class="btn btn-primary" target="_blank" href="{{ route('students.download', $class->id) }}">
                            <i class="mdi mdi-download"></i> Download Class List
                        </a>
                        <a class="btn btn-secondary" href="{{ route('class.students.export', $class->id) }}">
                            <i class="fas fa-file-export"></i> Export Class List
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Matricule</th>
                                <th>Full Name</th>
                                <th>Gender</th>
                                <th>Date of Birth</th>
                                <th>Place of Birth</th>
                                <th>Classe</th>
                                <th>Parent's Contact</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $key => $student)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $student->matricule }}</td>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ $student->sex == 'male' ? 'M' : 'F' }}</td>
                                    <td>{{ $student->date_of_birth }}</td>
                                    <td>{{ $student->place_of_birth }}</td>
                                    <td>{{ $student->classe->name }}</td>
                                    <td>{{ $student->parents_contact }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-success">Edit</a>
                                        <form action="{{ route('students.delete', $student->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                        </form>
                                        <script>
                                            function confirmDelete() {
                                                return confirm('{{ __('Are you sure ??') }}');
                                            }
                                        </script>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-info text-center">
                                        <h5>NO DATA FOUND</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $students->links('pagination::simple-bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
