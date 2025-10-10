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
        <!-- <div class="stu-db">
            <div class="container pg-inn">
                <div class="col-md-3">
                    <div class="pro-user">
                        @if ($student->profile) 
                            <img src="{{ asset('storage/'.$student->profile) }}" alt="">
                        @else 
                        <img src="../../../images/profile.png" alt="user">
                        @endif
                    </div>
                    <div class="pro-user-bio">
                        <ul>
                            <li>
                                <h4>{{ $student->fname }} {{$student->lname}}</h4>
                            </li>
                            <li>Student Id: {{ $student->student_id }}</li>
                            <li><a href="#!"><i class="fa fa-envelope"></i>Email: {{ $student->email }}</a></li>
                            <li><a href="#!"><i class="fa fa-calendar"></i>Birthday: {{ $student->dob }}</a></li>
                            <li><a href="#!"><i class="fa fa-twitter"></i> Program: my sample</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="udb">

                        <div class="udb-sec udb-prof">
                            <h4><img src="images/icon/db1.png" alt="" /> My Profile</h4>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed
                                to using 'Content here, content here', making it look like readable English.</p>
                            <div class="sdb-tabl-com sdb-pro-table">
                                <table class="responsive-table bordered">
                                    <tbody>
                                        <tr>
                                            <td>Student Name</td>
                                            <td>:</td>
                                            <td>{{ $student->fname }} {{ $student->lname }}</td>
                                        </tr>
                                        <tr>
                                            <td>Student Id</td>
                                            <td>:</td>
                                            <td>{{ $student->student_id }}</td>
                                        </tr>
                                        <tr>
                                            <td>Eamil</td>
                                            <td>:</td>
                                            <td>{{ $student->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>:</td>
                                            <td>{{  $student->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date of birth</td>
                                            <td>:</td>
                                            <td>{{ $student->dob }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>:</td>
                                            <td>{{ $student->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td><span class="db-done text-success">Active</span> </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="sdb-bot-edit">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                                    <a href="#" class="waves-effect waves-light btn-large sdb-btn sdb-btn-edit"><i class="fa fa-pencil"></i> Edit my profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="row grey lighten-5" style="padding: 20px; height: auto;">
            <div class="container">
                <div class="col s12 m3" style="height:auto;">
                    <div class="grey lighten-3 p-5" style="padding:10px 0">
                        <div class="text-center">
                            {{-- <img 
                            class="responsive-img" 
                            src="https://i.pinimg.com/736x/2b/90/7e/2b907e8ab481caf2a0f2c9cd0b500a2d.jpg" 
                            alt="User" 
                            style="width: 200px; height:200px; object-fit:cover; margin:10px 0; border-radius:15px;"
                            /> --}}
                            <img src="{{ asset('storage/'.$student->profile) }}" alt="">
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
                        <h3 class="col s12 m9">First Year</h3>

                        <!-- Dropdown Trigger -->
                         <div class="col s12 m3" style="position: relative;">
                            <button class="btn dropdown-trigger" style="border:none; outline:none;" data-target="dropdown1">First Year <small style="margin-left:10px; color:white; font-weight:900;">v</small></button>
                            <ul id="dropdown1" class="dropdown-content" style="z-index:100;">
                                <li><a href="javascript:void(0)">First Year</a></li>
                                <li><a href="{{ route('student.second',['identifier' => $identifier]) }}">Second Year</a></li>
                                <li><a href="javascript:void(0)">Third Year</a></li>
                                <li><a href="javascript:void(0)">Fourth Year</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="border-bottom scrollable">
                        <div class="overflow-x-auto">
                            <div style="margin:10px 0">
                                <h3 class="p-3">First Year First Semester</h3>
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
                                <h3 class="p-3">First Year Second Semester</h3>
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
                            <h5 class="white-text" style="margin-bottom:5px">First Year First Semester GPA</h5>
                            <span class="chip">3.5</span>
                        </div>
                        <div class="col s4 center-align border-x">
                            <h5 class="white-text" style="margin-bottom:5px">First Year Second Semester GPA</h5>
                            <span class="chip">3.5</span>
                        </div>
                        <div class="col s4 center-align">
                            <h5 class="white-text" style="margin-bottom:5px">First Year Overall GPA</h5>
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
