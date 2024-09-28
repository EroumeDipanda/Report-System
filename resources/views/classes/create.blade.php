@extends('layouts.app')

@section('title', 'Create Classe')

@section('content')
    <div class="col-md-8 col-xl-8 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">CREATE NEW CLASSE</h5>
                        <form action="{{ route('classes.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Classe Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    autofocus required>
                            </div>
                            <div class="mb-3">
                                <label for="code_classe" class="form-label">Class Code</label>
                                <input type="text" class="form-control" id="code_classe" name="code_classe"
                                    placeholder="" required readonly>
                            </div>

                            <div class="mb-3">
                                <label for="classe_master" class="form-label">Classe Master</label>
                                <input type="text" class="form-control" id="classe_master" name="classe_master"
                                    placeholder="">
                            </div>

                            <button type="submit" class="btn btn-fw p-2 btn-success">Save Classe
                                </button>
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

                    // Get the current year
                    const year = new Date().getFullYear();

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
