@extends('layouts.app')

@section('title', 'Edit Subject')

@section('content')
<div class="col-md-8 col-xl-12 middle-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">EDIT SUBJECT</h5>
                    <form action="{{ route('subjects.update', $subject->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Subject Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $subject->name) }}" autofocus required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="code_subject" class="form-label">Subject Code</label>
                            <input type="text" class="form-control @error('code_subject') is-invalid @enderror" id="code_subject" name="code_subject" value="{{ old('code_subject', $subject->code_subject) }}" required readonly>
                            @error('code_subject')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="classe">Select Class:</label>
                            <select name="classe_id" id="classe" class="form-control @error('classe_id') is-invalid @enderror" required>
                                {{-- <option>Select Class</option>
                                @foreach($classes as $class) --}}
                                    <option value="{{ $class->id }}" {{ (old('classe_id', $subject->classe_id) == $class->id) ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                {{-- @endforeach --}}
                            </select>
                            @error('classe_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <div>
                                    <label for="teacher" class="form-label">Teacher's Name</label>
                                    <input type="text" class="form-control" id="teacher" name="teacher" placeholder="Enter Teacher's Name" value="{{ old('teacher', $subject->teacher) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div>
                                    <label for="coef" class="form-label">Coefficient</label>
                                    <input type="number" class="form-control @error('coef') is-invalid @enderror" id="coef" name="coef" value="{{ old('coef', $subject->coef) }}" required>
                                    @error('coef')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-fw p-2 btn-success">Update Subject</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
