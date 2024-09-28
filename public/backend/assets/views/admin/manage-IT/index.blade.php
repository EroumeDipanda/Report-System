@extends('layouts.app')

@section('title', __('messages.staff.list_title'))

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="text-end mb-3">
                            <a class="btn btn-success d-inline-flex align-items-center"
                               href="{{ route('user.create') }}" style="font-size: 0.75rem;">
                                {{ __('messages.staff.create_button') }}<i class="ms-2 mdi mdi-plus-circle mdi-24px"></i>
                            </a>
                        </div>
                        <h3 class="card-title">{{ __('messages.staff.list_title') }}</h3>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.staff.table_headers.serial') }}</th>
                                        <th>{{ __('messages.staff.table_headers.name') }}</th>
                                        <th>{{ __('messages.staff.table_headers.email') }}</th>
                                        <th>{{ __('messages.staff.table_headers.username') }}</th>
                                        <th>{{ __('messages.staff.table_headers.contact') }}</th>
                                        <th>{{ __('messages.staff.table_headers.school') }}</th>
                                        <th>{{ __('messages.staff.table_headers.actions') }}</th>
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
                                                @if ($user->school)
                                                    {{ $user->school->name }}
                                                @else
                                                    NULL
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('user.destroy', $user->id)}}" method="POST"
                                                    onsubmit="return confirm('{{ __('messages.staff.delete_confirmation') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success">
                                                        {{ __('messages.staff.edit_title') }}
                                                    </a>
                                                    <button type="submit" class="btn btn-danger">
                                                        {{ __('messages.staff.delete') }}
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
