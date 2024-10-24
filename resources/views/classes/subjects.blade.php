@extends('layouts.app')

@section('title', 'Subjects')

@section('content')

<div class="page-content">
    <div class="row profile-body">
        <!-- Left Sidebar -->
        <div class="col-12">
            <div class="card shadow-sm rounded">
                <div class="card-body text-center">
                    <h3 class="card-title">LISTES DE MATIERE DE {{ $class->name }}</h3>
                </div>
                <div class="text-end pe-3">
                    <a class="btn btn-success d-inline-flex align-items-center" href="{{ route('subjects.create', $class->id) }}">
                        Ajouter une Matiere <i class="ms-2 mdi mdi-plus-circle mdi-24px"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Matiere</th>
                                    <th>Coef</th>
                                    <th>Enseignants</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $key => $subject)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->coef }}</td>
                                        <td>{{ $subject->teacher ? $subject->teacher : '/' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-success">Modifier</a>
                                            <form action="{{ route('subjects.delete', $subject->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">{{ __('Supprimer') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-info text-center">
                                            <h5>NO DATA FOUND</h5>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <h5 class="text-muted mb-0">PROFESSEUR PRINCIPAL: {{ $class->classe_master ? $class->classe_master : '' }}</h5>
                </div>
            </div>
        </div>
        <!-- End Left Sidebar -->
    </div>
</div>

@endsection
