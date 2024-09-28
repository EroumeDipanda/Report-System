@extends('layouts.app')

@section('title', 'Create Mark')

@section('content')
    <div class="row">
        <div class="col-lg-12 m-0 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <h3 class="card-title">CREATE MARKS</h3>
                        </div>
                        <div class="col-md-7 text-end">
                            <!-- Export and Import Buttons -->
                            <div id="action-buttons">
                                <a href="{{ route('marks.export') }}" id="export-btn"
                                    class="btn btn-success p-2">Export Marks</a>
                                <a href="{{ route('marks.import') }}" id="import-btn"
                                    class="btn btn-info p-2">Import Marks</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <form id="marks-form" method="POST" action="{{ route('marks.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <!-- Left Column for Selection -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="classe_id" class="form-label">Class</label>
                                    <select id="classe_id" name="classe_id" class="form-select">
                                        <option value="">Select a class</option>
                                        @foreach ($classes as $classe)
                                            <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="subject_id" class="form-label">Subject</label>
                                    <select id="subject_id" name="subject_id" class="form-select">
                                        <option value="">Select a subject</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="sequence" class="form-label">Sequence</label>
                                    <select id="sequence" name="sequence" class="form-select">
                                        <option selected>Select Evaluation</option>
                                        <option value="1">Evaluation 1</option>
                                        <option value="2">Evaluation 2</option>
                                        <option value="3">Evaluation 3</option>
                                        <option value="4">Evaluation 4</option>
                                        <option value="5">Evaluation 5</option>
                                        <option value="6">Evaluation 6</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Marks</button>
                            </div>

                            <!-- Right Column for Student List -->
                            <div class="col-md-8">
                                <div class="col-lg-12 grid-margin stretch-card" id="students-card" style="display:none;">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">LIST OF STUDENTS</h4>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Matricule</th>
                                                            <th>Name</th>
                                                            <th>Mark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="students-container">
                                                        <!-- Student list will be populated here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('classe_id').addEventListener('change', function() {
            const classId = this.value;

            if (classId) {
                // Fetch subjects for the selected class
                fetch(`/classes/${classId}/subjects`)
                    .then(response => response.json())
                    .then(subjects => {
                        const subjectSelect = document.getElementById('subject_id');
                        subjectSelect.innerHTML = '<option value="">Select a subject</option>';
                        subjects.forEach(subject => {
                            subjectSelect.innerHTML +=
                                `<option value="${subject.id}">${subject.name}</option>`;
                        });
                    });

                // Fetch students for the selected class
                fetch(`/classes/${classId}/students`)
                    .then(response => response.json())
                    .then(students => {
                        const studentsCard = document.getElementById('students-card');
                        const studentsContainer = document.getElementById('students-container');
                        studentsContainer.innerHTML = ''; // Clear previous data
                        studentsCard.style.display = 'block'; // Show the card with students list

                        students.forEach((student, index) => {
                            studentsContainer.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${student.matricule}</td>
                            <td>${student.first_name} ${student.last_name}</td>
                            <td><input type="tel" name="marks[${student.id}]" class="form-control" style="width: 100px;" placeholder="Enter mark"></td>
                        </tr>
                    `;
                        });

                        // Show export and import buttons
                        document.getElementById('action-buttons').style.display = 'block';

                        // Update the export button href with current selections
                        updateExportLink(classId);
                    });
            } else {
                // Hide the students card and clear the container if no class is selected
                document.getElementById('students-card').style.display = 'none';
                document.getElementById('students-container').innerHTML = '';
                document.getElementById('action-buttons').style.display = 'none'; // Hide buttons
            }
        });

        document.getElementById('subject_id').addEventListener('change', function() {
            const subjectId = this.value;
            const classId = document.getElementById('classe_id').value;
            const sequence = document.getElementById('sequence').value;

            // Update the export link when the subject changes
            updateExportLink(classId, subjectId, sequence);
        });

        document.getElementById('sequence').addEventListener('change', function() {
            const sequence = this.value;
            const classId = document.getElementById('classe_id').value;
            const subjectId = document.getElementById('subject_id').value;

            // Update the export link when the sequence changes
            updateExportLink(classId, subjectId, sequence);
        });

        function updateExportLink(classId, subjectId, sequence) {
            const exportBtn = document.getElementById('export-btn');
            if (classId && subjectId && sequence) {
                exportBtn.href = `/export/marks?classe_id=${classId}&subject_id=${subjectId}&sequence=${sequence}`;
                exportBtn.style.display = 'inline-block'; // Show button if parameters are valid
            } else {
                exportBtn.style.display = 'none'; // Hide button if parameters are not valid
            }
        }
    </script>

@endsection
