@extends('layouts.app')

@section('title', __('messages.school.update'))

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin">
                    <div class="container">
                        <div class="card p-4 shadow-sm pt-5">
                            <h3 class="card-title text-center mb-4">{{ __('messages.school.update') }}</h3>
                            <form class="forms-sample" action="{{ route('schools.update', $school->id) }}" method="POST" enctype="multipart/form-data" style="width: 80%; margin: 0 auto;">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="name" class="form-label">{{ __('messages.school.school_name') }}</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" value="{{ $school->name }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">{{ __('messages.school.email') }}</label>
                                        <input type="email" class="form-control" id="email" name="email" autocomplete="off" value="{{ $school->email }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact" class="form-label">{{ __('messages.school.contact') }}</label>
                                        <input type="text" class="form-control" id="contact" name="contact" autocomplete="off" value="{{ $school->contact }}">
                                    </div>
                                </div>
                                <div class="text-center mt-3 mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-3 mb-4">{{ __('messages.school.update') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
