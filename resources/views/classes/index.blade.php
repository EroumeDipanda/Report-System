@extends('layouts.app')

@section('title', 'All classes')

@section('content')

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="text-end mb-3">
                        <a class="btn btn-success d-inline-flex align-items-center" href="{{ route('classes.create') }}">
                            Create New Classe <i class=" ms-2 mdi mdi-plus-circle mdi-24px"></i>
                        </a>
                    </div>
                    <h3 class="card-title">LIST OF ALL CLASSES</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Classe Name</th>
                                    {{-- <th>Classe Code</th> --}}
                                    <th>Classe Master</th>
                                    <th>Assigned Classes</th>
                                    <th>Students</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classes as $key => $class)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $class->name }}</td>
                                        {{-- <td>{{ $class->code_classe }}</td> --}}
                                        <td>{{ $class->classe_master ? $class->classe_master : 'N/A' }}
                                        </td>
                                        <td>

                                            <a href="{{ route('class.subjects', $class->id) }}"class="btn btn-success"><i
                                                    class="mdi mdi-file-document-box"></i>Matieres</a>
                                        </td>
                                        <td><a href="{{ route('class.students', $class->id) }}"class="btn btn-success"><i
                                                    class="mdi mdi-account-multiple"></i> Eleves</a></td>
                                        <td class="text-center">
                                            <a href="{{ route('classes.edit', $class->id) }}"
                                                class="btn btn-success">Modifier</a>
                                            <form action="{{ route('classes.delete', $class->id) }}" method="POST"
                                                style="display:inline;" onsubmit="return confirmDelete();">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    {{ __('Supprimer') }}
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
                </div>
            </div>
        </div>
    </div>
@endsection
