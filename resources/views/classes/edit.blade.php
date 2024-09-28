@extends('layouts.app')

@section('title', 'Edit Classe')

@section('content')
<div class="col-md-8 col-xl-8 middle-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">EDIT CLASSE</h5>
                    <form action="{{ route('classes.update', $class->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Classe Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $class->name) }}" autofocus required>
                        </div>
                        <div class="mb-3">
                            <label for="code_classe" class="form-label">Class Code</label>
                            <input type="text" class="form-control" id="code_classe" name="code_classe"
                                value="{{ old('code_classe', $class->code_classe) }}" required readonly>
                        </div>

                        <div class="mb-3">
                            <label for="classe_master" class="form-label">Class Master</label>
                            <input type="text" class="form-control" id="classe_master" name="classe_master"
                                value="{{ old('classe_master', $class->classe_master) }}">
                        </div>

                        <button type="submit" class="btn btn-fw p-2 btn-success">Update Classe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('name');
        const codeClasseInput = document.getElementById('code_classe');

        nameInput.addEventListener('input', function () {
            const className = nameInput.value;
            if (className.length > 0) {
                // Get the first and last character of the class name
                const firstChar = className.charAt(0).toUpperCase();
                const lastChar = className.charAt(className.length - 1).toUpperCase();

                // Combine the elements to create the code
                const codeClasse = `${firstChar}${lastChar}`;
                codeClasseInput.value = codeClasse;
            } else {
                codeClasseInput.value = ''; // Clear if class name is empty
            }
        });
    });
</script>

@endsection
