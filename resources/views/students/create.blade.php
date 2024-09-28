@extends('layouts.app')

@section('title', 'Create Students')

@section('content')
    <div class="col-md-8 col-xl-12 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">CREATE NEW STUDENT</h4>
                        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name"
                                        value="{{ old('first_name') }}" autofocus>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ old('last_name') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth"
                                        value="{{ old('date_of_birth') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="place_of_birth" class="form-label">Place of Birth</label>
                                    <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth" name="place_of_birth"
                                        value="{{ old('place_of_birth') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="first_name" class="form-label">Gender</label>
                                    <select name="sex" class="form-select @error('sex') is-invalid @enderror" id="">
                                        <option value="male" selected>Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="classe_id" class="form-label">Classe</label>
                                    <select name="classe_id" class="form-select @error('classe_id') is-invalid @enderror" id="classe_id">
                                        <option selected>Select Classe</option>
                                        @forelse ($classes as $classe)
                                            <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                                        @empty
                                            <option>No Classe Found</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="matricule" class="form-label">Matricule</label>
                                    <input type="text" class="form-control @error('matricule') is-invalid @enderror" id="matricule" name="matricule" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="parents_contact" class="form-label">Parent's Contact</label>
                                    <input type="tel" class="form-control" id="parents_contact" name="parents_contact"
                                        value="{{ old('parents_contact') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="photo" class="form-label">Upload Image</label>
                                    <input type="file" class="form-control" id="photo" name="photo">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-fw p-2 btn-success">Register Student</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Matricule Generation Script -->
    <script>
        // Function to generate a student matricule
        function generateMatricule() {
            // Retrieve selected class name
            const classSelect = document.getElementById('classe_id');
            const selectedOption = classSelect.options[classSelect.selectedIndex];
            const className = selectedOption.text || 'XX';

            // Determine class code based on class name
            const classCode = getClassCode(className);

            // Retrieve student names
            const firstName = document.getElementById('first_name').value.trim() || '';
            const lastName = document.getElementById('last_name').value.trim() || '';

            // Generate name codes
            const firstNameCode = firstName.substring(0, 2).toUpperCase();
            const lastNameCode = lastName.substring(0, 2).toUpperCase();

            // Get the current year suffix
            const yearSuffix = new Date().getFullYear().toString().slice(-2);

            // Generate a shorter unique sequence number using a combination of timestamp and random number
            const uniqueSequence = Math.floor(Math.random() * 1000).toString().padStart(3, '0'); // 3 random digits

            // Construct matricule
            const matricule = `CBP${yearSuffix}${firstNameCode}${lastNameCode}${uniqueSequence}${classCode}`;

            // Set matricule to the input field
            document.getElementById('matricule').value = matricule;
        }

        // Helper function to determine class code
        function getClassCode(className) {
            const formMatch = className.match(/form\s*(\d+)/i);
            const gradeMatch = className.match(/grade\s*(\d+)/i);

            if (formMatch) {
                return 'F' + formMatch[1]; // Example: "Form 4" -> "F4"
            } else if (gradeMatch) {
                return 'G' + gradeMatch[1]; // Example: "Grade 10" -> "G10"
            } else {
                return className.substring(0, 2).toUpperCase(); // Fallback
            }
        }

        // Event listeners to update matricule in real-time
        document.getElementById('classe_id').addEventListener('change', generateMatricule);
        document.getElementById('first_name').addEventListener('input', generateMatricule);
        document.getElementById('last_name').addEventListener('input', generateMatricule);
    </script>

@endsection
