<x-layout>
        <!--SECTION START-->
    <section>
        <style>
            details {
                width: 200px;
                cursor: pointer;
            }
            summary {
                background: #3498db;
                color: white;
                padding: 10px;
                font-size: 16px;
                border-radius: 5px;
                list-style: none;
            }
            details[open] summary {
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }
            details div {
                background: #ecf0f1;
                padding: 10px;
                border-radius: 5px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }

            .gpa{
                margin-top:20px; 
                padding:20px 0; 
                background: #fff; 
                box-shadow: 0px 5px 18px -11px rgba(150, 150, 150, 1); 
                border: 1px solid #f3f2f2;
            }

            .gpa h5{
                margin-bottom:10px;
            }

            .gpa span, .gpa a{
                background:#3498db;
                color:#fff;
                font-size:16px;
                padding:5px 20px;
                border-radius:5px;
            }
        </style>
        <div class="pro-cover no-print">
        </div>
        <div class="pro-menu no-print">
            <div class="container">
                <div class="col-md-9 col-md-offset-3">
                    <ul>
                        <li><a href="{{ route('student.profile',['identifier' => $identifier]) }}" class="pro-act">Profile</a></li>
                        <li><a href="{{ route('student.courses',['identifier' => $identifier]) }}">Courses</a></li>
                        <li><a href="javascript:void(0);">Time Line</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="stu-db">
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
                            <li>Bachelor Science in Information Technology</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="">
                        <h3>First Year</h3>  
                        <details>
                            <summary>Choose Year</summary>
                            <div>
                                <p><a href="javascript:void(0)">First Year</a></p>
                                <p><a href="{{ route('student.second',['identifier' => $identifier]) }}">Second Year</a></p>
                                <p><a href="javascript:void(0)">Third Year</a></p>
                                <p><a href="javascript:void(0)">Fouth Year</a></p>
                            </div>
                        </details>
                    </div>
                    <div class="udb">
                        <h3>First Semester</h3>
                        <div class="pro-con-table">
                            <table class="bordered responsive-table">
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
                                        <td>Python Programming</td>
                                        <td>A</td>
                                    </tr>   
                                    <tr>
                                        <td>1</td>
                                        <td>Python Programming</td>
                                        <td>A</td>
                                    </tr>   
                                    <tr>
                                        <td>1</td>
                                        <td>Python Programming</td>
                                        <td>A</td>
                                    </tr>   
                                    <tr>
                                        <td>1</td>
                                        <td>Python Programming</td>
                                        <td>A</td>
                                    </tr>   
                                    <tr>
                                        <td>1</td>
                                        <td>Python Programming</td>
                                        <td>A</td>
                                    </tr>   
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="udb">
                        <h3>Second Semester</h3>
                        <div class="pro-con-table">
                            <table class="bordered responsive-table">
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
                                        <td>Python Programming</td>
                                        <td>A</td>
                                    </tr>   
                                    <tr>
                                        <td>1</td>
                                        <td>Python Programming</td>
                                        <td>A</td>
                                    </tr>   
                                    <tr>
                                        <td>1</td>
                                        <td>Python Programming</td>
                                        <td>A</td>
                                    </tr>   
                                    <tr>
                                        <td>1</td>
                                        <td>Python Programming</td>
                                        <td>A</td>
                                    </tr>   
                                    <tr>
                                        <td>1</td>
                                        <td>Python Programming</td>
                                        <td>A</td>
                                    </tr>   
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row text-center gpa">
                        <div class="col s12 m6 center-align">
                               <h5>FIRST YEAR GPA</h5>
                                <span>3.5</span>
                        </div>
                        <div class="col s12 m6 center-align">
                           <h5>You can print GPA yourself</h5>
                           <a href="javascript:void(0)">Print GPA</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    
    <!--SECTION END-->
</x-layout> 