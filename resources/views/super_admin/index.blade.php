@extends('layouts.app')

@section('title', 'Liste des administrateurs')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="text-end mb-3">
                            <a class="btn btn-success d-inline-flex align-items-center"
                               href="{{ route('admins.create') }}" style="font-size: 0.75rem;">
                                Creer Nouveau Admin<i class="ms-2 mdi mdi-plus-circle mdi-24px"></i>
                            </a>
                        </div>
                        <h3 class="card-title">LISTES DES ADMINISTRATEURS</h3>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.staff.table_headers.serial') }}</th>
                                        <th>Noms d'Admins</th>
                                        <th>Email</th>
                                        <th>Noms d'utilisateur</th>
                                        <th>Contact</th>
                                        <th>Etablissement en Charge</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <img style="height: 40px; width:40px" class="me-2 rounded-circle"
                                                     src="{{ !empty($user->photo) ? url('upload/profiles/' . $user->photo) : url('upload/no_image.jpg') }}"
                                                     alt="profile">{{ $user->name }}
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->contact }}</td>
                                            <td>
                                                @if ($user->adminSchools->isNotEmpty())
                                                    @foreach ($user->adminSchools as $school)
                                                        <span class="badge badge-info">{{ $school->name }}</span> <!-- Display each school name, separated by commas -->
                                                    @endforeach
                                                @else
                                                    <span class="badge badge-danger">NULL</span>
                                                @endif
                                            </td>

                                            <td>
                                                <form action="{{ route('admins.destroy', $user->id)}}" method="POST"
                                                    onsubmit="return confirm('{{ __('messages.staff.delete_confirmation') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('admins.edit', $user->id) }}" class="btn btn-success">
                                                        Modifier
                                                    </a>
                                                    <button type="submit" class="btn btn-danger">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
