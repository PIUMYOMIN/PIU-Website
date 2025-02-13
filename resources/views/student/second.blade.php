<x-layout>
        <!--SECTION START-->
    <section>
        <style>
            td,th{
                padding: 10px 0;
            }
        </style>

        <div class="pro-cover">
        </div>
        <div class="pro-menu">
            <div class="container">
                <div class="col-md-9 col-md-offset-3">
                    <ul>
                        <li><a href="{{ route('student.profile',['identifier' => $identifier]) }}" class="pro-act">Profile</a></li>
                        <li><a href="{{ route('student.courses',['identifier' => $identifier]) }}">Courses</a></li>
                        <li><a href="{{ route('student.exams',['identifier' => $identifier]) }}">Calendar</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row grey lighten-5" style="padding: 20px; height: auto;">
            <div class="container">
                <div class="col s12 m3" style="height:auto;">
                    <div class="grey lighten-3 p-5" style="padding:10px 0">
                        <div class="text-center">
                            <img 
                            class="responsive-img" 
                            src="https://i.pinimg.com/736x/2b/90/7e/2b907e8ab481caf2a0f2c9cd0b500a2d.jpg" 
                            alt="User" 
                            style="width: 200px; height:200px; object-fit:cover; margin:10px 0; border-radius:15px;"
                            />
                        </div>
                        <div class="" style="margin-left:10px;">
                            <p class=""><strong>Name :</strong> {{ $student->fname }} {{$student->lname}}</p>
                            <p><strong>Student ID :</strong> {{ $student->student_id }}</p>
                            <p><strong>Email :</strong> {{ $student->email }}</p>
                            <p><strong>DOB :</strong> {{ $student->dob }}</p>
                            <p class=""><strong>Major :</strong> Bachelor of Science in Information Technology</p>
                        </div>
                    </div>
                </div>
                
                <div class="col s12 m9">
                    <div class="row">
                        <h3 class="col s12 m9">Second Year</h3>

                        <!-- Dropdown Trigger -->
                         <div class="col s12 m3" style="position: relative;">
                            <button class="btn dropdown-trigger" style="border:none; outline:none;" data-target="dropdown2">Second Year <small style="margin-left:10px; color:white; font-weight:900;">v</small></button>
                            <ul id="dropdown2" class="dropdown-content" style="z-index:100;">
                                <li><a href="{{ route('student.profile',['identifier' => $identifier]) }}">First Year</a></li>
                                <li><a href="javascript:void(0)">Second Year</a></li>
                                <li><a href="javascript:void(0)">Third Year</a></li>
                                <li><a href="javascript:void(0)">Fourth Year</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-bottom scrollable">
                        <div class="overflow-x-auto">
                            <div style="margin:10px 0">
                                <h3 class="p-3">Second Year First Semester</h3>
                                <table class="striped bordered responsive-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Major</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Data Analysis</td>
                                            <td>A</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Algorithms</td>
                                            <td>B</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Algorithms</td>
                                            <td>B</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Algorithms</td>
                                            <td>B</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div style="margin:10px 0">
                                <h3 class="p-3">Second Year Second Semester</h3>
                                <table class="striped bordered responsive-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Major</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Data Analysis</td>
                                            <td>A</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Algorithms</td>
                                            <td>B</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Algorithms</td>
                                            <td>B</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Algorithms</td>
                                            <td>B</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="mrgin:10px 0; background:#757575; padding:20px 0">
                        <div class="col s4 center-align">
                            <h5 class="white-text" style="margin-bottom:5px">Second Year First Semester GPA</h5>
                            <span class="chip">3.5</span>
                        </div>
                        <div class="col s4 center-align border-x">
                            <h5 class="white-text" style="margin-bottom:5px">Second Year Second Semester GPA</h5>
                            <span class="chip">3.5</span>
                        </div>
                        <div class="col s4 center-align">
                            <h5 class="white-text" style="margin-bottom:5px">Second Year Overall GPA</h5>
                            <span class="chip">3.5</span>
                        </div>
                    </div>

                    <div class="text-center" style="padding:20px 0">
                        <button onclick="AlertGPA()" style="background:skyblue; border:none; font-size: 16px; font-weight: 600; padding:10px">Print Your GPA</button>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var elems = document.querySelectorAll('.dropdown-trigger');
                var instances = M.Dropdown.init(elems);
            });

            function AlertGPA() {
                alert("Couldn't print right now");
            }
        </script>

    </section>
    <!--SECTION END-->
</x-layout>
