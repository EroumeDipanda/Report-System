@extends('layouts.app')

@section('title', 'All students')

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="text-end mb-3">
                        <a class="btn btn-success d-inline-flex align-items-center" href="{{ route('students.create') }}">
                            Create New Student <i class=" ms-2 mdi mdi-plus-circle mdi-24px"></i>
                        </a>
                    </div>
                    <h3 class="card-title">LIST OF ALL STUDENTS</h3>
                    <div class="table-responsive" style="overflow: auto">
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
                                    {{-- <th>Created At</th> --}}
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $key => $student)
                                    <tr>
                                        <td>{{ $startingNumber + $key }}</td>
                                        <td>{{ $student->matricule }}</td>
                                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                        <td>{{ $student->sex == 'male' ? 'M' : 'F' }}</td>
                                        <td>{{ $student->date_of_birth }}</td>
                                        <td>{{ $student->place_of_birth }}</td>
                                        <td>{{ $student->classe->name }}</td>
                                        <td>{{ $student->parents_contact }}</td>
                                        {{-- <td>{{ \Carbon\Carbon::parse($student->created_at)->format('F j, Y, g:i A') }}</td> --}}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('students.edit', $student->id) }}"
                                                class="btn btn-success">Edit</a>
                                            <form action="{{ route('students.delete', $student->id) }}" method="POST"
                                                style="display:inline;" onsubmit="return confirmDelete();">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>

                                            <script>
                                                function confirmDelete() {
                                                    // Display a confirmation dialog
                                                    return confirm('{{ __('Are you sure ??') }}');
                                                }
                                            </script>

                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="11" class="text-info text-center">
                                        <h5>NO DATA FOUND</h5>
                                    </td>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $students->links('pagination::simple-bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
