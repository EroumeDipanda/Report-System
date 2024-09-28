@extends('layouts.app')

@section('title', __('messages.marks.title_upload'))

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="col-md-12 grid-margin">
                    <div class="container">
                        <div class="card p-4 shadow-sm pt-5">
                            <form action="{{ route('marks.store') }}" method="POST" enctype="multipart/form-data" style="width: 80%; margin: 0 auto;">
                                @csrf
                                <h3>{{ __('messages.marks.title_upload') }}</h3>
                                <div class="form-group">
                                    <label for="file">{{ __('messages.marks.form_label_file') }}</label>
                                    <input type="file" name="file" id="file" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('messages.marks.button_upload') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
