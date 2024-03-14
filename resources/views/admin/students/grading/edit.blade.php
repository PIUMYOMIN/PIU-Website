<x-admin_layout>
    {{-- @dd($student) --}}
  <div class="sb2-2-2">
            <ul>
                <li><a href="/admin"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                </li>
                <li class="active-bre"><a href="#"> Add New GPA</a>
                </li>
                <li class="page-back"><a href="/admin"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                </li>
            </ul>
        </div>

        <!--== User Details ==-->
        <div class="sb2-2-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-inn-sp admin-form">
                        <div class="sb2-2-add-blog sb2-2-1">
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade active in">
                                    <div class="box-inn-sp">
                                        <div class="bor">
                                            <form
                                                action="{{ route('admin.student.grading.update', ['student' => $student, 'grading' => $grading, 'semester' => $semester]) }}"
                                                method="POST" id="first-semester-form">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                <input type="hidden" name="semester_id" value="{{ $semester->id }}">
                                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                                <div class="row">
                                                    <div class="input-field col s12">
                                                        <div class="row">
                                                            <h1 class="text-center">{{ $student->fname }} {{ $student->lname }}</h1>
                                                        </div>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <div class="row">
                                                            <div class="input-field col s6">
                                                                <div class="input-field">
                                                                    <input type="text" name="course_id" value="{{ $student->course->title }}" disabled>
                                                                    <input type="hidden" name="course_id" value="{{ $student->course->id }}">
                                                                @error('course_id')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                                </div>
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <select class="input-field col s12"
                                                                    name="year_id">
                                                                    @foreach ($years as $year)
                                                                        <option
                                                                            {{ $year->id == old('year_id') ? 'selected' : '' }}
                                                                            value="{{ $year->id }}">{{ $year->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('year_id')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <select class="input-field col s12" name="module_id">
                                                                    @foreach ($modules as $module)
                                                                        <option {{ $grading->module_id == $module->id ? 'selected' : '' }} value="{{ $module->id }}">{{ $module->module_code }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('module_id')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                            </div>
                                                            <div class="input-field col s6">
                                                                <select class="input-field col s12" name="assignment_id">
                                                                    @foreach ($assignments as $assignment)
                                                                        <option {{ $grading->assignment_id == $assignment->id ? 'selected' : '' }} value="{{ $assignment->id }}">{{ $assignment->name }}</option>
                                                                        @error('assignment_id')
                                                                            <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="row">
                                                                <div class="input-field col s6">
                                                                    <div class="input-field col s12">
                                                                        <input type="text" name="mark" value="{{ $grading->mark }}"
                                                                            placeholder="Enter Marks">
                                                                    </div>
                                                                    @error('mark')
                                                                        <p class="text-danger">{{ $message }}</p>
                                                                    @enderror
                                                                </div>
                                                                <div class="input-field col s6">
                                                                    <div class="row">
                                                                        <div class="input-field col s4">
                                                                            <input type="text" id="grade_point" name="grade_point" placeholder="GPA Point" readonly>
                                                                        </div>
                                                                        @error('grade_point')
                                                                            <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                        <div class="input-field col s4">
                                                                            <input type="text" id="grade_value"
                                                                            name="grade_value" placeholder="GPA Value"
                                                                            readonly>
                                                                        </div>
                                                                        @error('grade_value')
                                                                            <p class="text-danger">{{ $message }}</p>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row d-flex justify-content-center align-items-center">
                                                    <div class="input-field col s12 text-center">
                                                        <div class="col s4">
                                                            <button type="submit" class="waves-effect waves-light btn-large">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
    // Get the input elements
    const gradePointInput = document.querySelector('input[name="mark"]');
    const gpaValueInput = document.getElementById('grade_value');
    const gpaPointInput = document.getElementById('grade_point');

    // Function to calculate and update GPA value
    function updateGpaValue() {
        const gradePoint = parseFloat(gradePointInput.value);
        if (!isNaN(gradePoint)) {
                if (gradePoint >= 90) {
                    gpaPointInput.value = '4.00';
                    gpaValueInput.value = 'A';
                } else if (gradePoint >= 80) {
                    gpaPointInput.value = '4';
                    gpaValueInput.value = 'A';
                } else if (gradePoint >= 75) {
                    gpaPointInput.value = '3';
                    gpaValueInput.value = 'B';
                } else if (gradePoint >= 70) {
                    gpaPointInput.value = '2';
                    gpaValueInput.value = 'C';
                } else if (gradePoint >= 65) {
                    gpaPointInput.value = '1';
                    gpaValueInput.value = 'D';
                } else if (gradePoint >= 50) {
                    gpaPointInput.value = '0.7';
                    gpaValueInput.value = 'E';
                } else {
                    gpaPointInput.value = '00';
                    gpaValueInput.value = 'Failed';
                }
            } else {
                gpaPointInput.value = '';
                gpaValueInput.value = '';
            }
    }

    // Add event listener to update GPA value when mark changes
    gradePointInput.addEventListener('input', updateGpaValue);

    // Call the updateGpaValue function initially to fill the GPA value based on the initial mark
    updateGpaValue();
</script>
</x-admin_layout>