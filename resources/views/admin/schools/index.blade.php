@extends('layouts.app')

@section('title', __('messages.school.list'))

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <div class="text-end mb-3">
                        <a class="btn btn-success d-inline-flex align-items-center" href="{{ route('schools.create') }}" style="font-size: 0.75rem;">
                            {{ __('messages.school.register') }}<i class="ms-2 mdi mdi-plus-circle mdi-24px"></i>
                        </a>
                    </div>
                    <h3 class="card-title">{{ __('messages.school.list_of_schools') }}</h3>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-center">{{ __('messages.school.school_name') }}</th>
                                <th class="text-center">{{ __('messages.school.number_of_files') }}</th>
                                <th class="text-center">{{ __('messages.school.number_of_classes') }}</th>
                                <th class="text-center">{{ __('messages.school.number_of_teachers') }}</th>
                                <th class="text-center">{{ __('messages.school.number_of_students') }}</th>
                                <th class="text-center">{{ __('messages.school.pass_code') }}</th>
                                <th class="text-center">{{ __('messages.school.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($schools as $key => $school)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $school->name }}</td>
                                        <td>{{ $school->uploaded_files_count }}</td>
                                        <td>{{ $school->classes_count }}</td>
                                        <td>{{ $school->teachers_count }}</td>
                                        <td>0</td>
                                        <td>{{ $school->code_school }}</td>
                                        <td>
                                            <form action="{{ route('schools.delete', $school->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.school.delete_confirmation') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('schools.show', $school->id) }}" class="btn btn-success">{{ __('messages.school.view') }}</a>
                                                <button type="submit" class="btn btn-danger">{{ __('messages.school.delete') }}</button>
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
