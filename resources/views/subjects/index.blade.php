@extends('layouts.app')

@section('title', 'All subjects')

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="text-end mb-3">
                            <a class="btn btn-success d-inline-flex align-items-center"
                                href="{{ route('subjects.create') }}">
                                Create New Classe <i
                                    class=" ms-2 mdi mdi-plus-circle mdi-24px"></i>
                            </a>
                    </div>
                    <h3 class="card-title">LIST OF ALL SUBJECTS</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Subject Name</th>
                                    {{-- <th>Subject Code</th> --}}
                                    <th>Classe</th>
                                    <th>Coefficient</th>
                                    <th>Teacher</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $key => $subject)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $subject->name }}</td>
                                        {{-- <td>{{ $subject->code_subject}}</td> --}}
                                        <td>{{ $subject->classe->name}}
                                        <td>{{ $subject->coef}}
                                        <td>{{ $subject->teacher? $subject->teacher : 'Not Found'}}
                                        </td>

                                        <td subject="text-center">
                                            <a href="{{ route('subjects.edit', $subject->id) }}"
                                                class="btn btn-success">Edit</a>
                                            <form action="{{ route('subjects.delete', $subject->id) }}" method="POST"
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
                                        <td colspan="7" class="text-info text-center">
                                            <h5>NO DATA FOUND</h5>
                                        </td>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <div class="m-3">
                        {{ $subjects->links('pagination::bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
