@extends('layouts.app')

@section('title', __('messages.school.view'))

@section('content')
<div class="page-content">
    <div class="row">
        <!-- School Information -->
        <div class="col-md-6 col-xl-6 grid-margin stretch-card">
            <div class="card rounded">
                <div class="card-body">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <img style="height: 100px; width:100px" class="wd-70 rounded-circle" src="{{ (!empty($school->photo) ? url('upload/profiles/'.$school->photo) : url('upload/no_image.jpg'))}}" alt="profile">
                            </div>
                        </div>
                        <div class="mt-3">
                            <h3 class="tx-11 fw-bolder mb-0 text-uppercase">{{ $school->name }}</h3>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">{{ __('messages.school.contact_email') }}:</label>
                            <p class="text-muted">{{ $school->email }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">{{ __('messages.school.contact_phone') }}:</label>
                            <p class="text-muted">{{ $school->contact }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">{{ __('messages.school.location') }}:</label>
                            <p class="text-muted">{{ $school->address }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">{{ __('messages.school.number_of_teachers') }}:</label>
                            <p class="text-muted">{{ $teachers->count() }}</p>
                        </div>
                        <div class="mt-3">
                            <form action="{{ route('schools.delete', $school->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.school.delete_confirmation') }}');">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-inverse-success">{{ __('messages.school.edit') }}</a>
                                <button type="submit" class="btn btn-inverse-danger">{{ __('messages.school.delete') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- List of Teachers -->
        <div class="col-md-6 col-xl-6">
            <div class="card rounded">
                <div class="card-body">
                    <h6 class="card-title">{{ __('messages.school.list_of_teachers') }}</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>{{ __('messages.school.teacher_name') }}</th>
                                <th>{{ __('messages.school.contact') }}</th>
                                <th>{{ __('messages.school.pass_code') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($teachers as $teacher)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->contact }}</td>
                                    <td>{{ $teacher->access_code }}</td>
                                </tr>
                                @empty
                                    <td colspan="4" class="text-info text-center"><h5>{{ __('messages.school.no_data_found') }}</h5></td>
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
