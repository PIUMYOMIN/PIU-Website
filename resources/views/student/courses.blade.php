<x-layout>
        <!--SECTION START-->
    <section>
        <style>
            th,td{
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
                            <li><a href="#!"><i class="fa fa-facebook"></i> Facebook: my sample</a></li>
                            <li><a href="#!"><i class="fa fa-google-plus"></i> Google: my sample</a></li>
                            <li><a href="#!"><i class="fa fa-twitter"></i> Twitter: my sample</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="udb">
                        <!-- <div class="udb-sec udb-cour">
                            <h4><img src="images/icon/db2.png" alt="" /> Booking Courses</h4>
                            <p>Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.The point of using Lorem Ipsummaking it look like readable English.</p>
                            <div class="sdb-cours">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <div class="list-mig-like-com com-mar-bot-30">
                                                <div class="list-mig-lc-img"> <img src="images/course/3.jpg" alt=""> <span class="home-list-pop-rat list-mi-pr">Duration:150 Days</span> </div>
                                                <div class="list-mig-lc-con">
                                                    <h5>Master of Science</h5>
                                                    <p>Illinois City,</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="list-mig-like-com com-mar-bot-30">
                                                <div class="list-mig-lc-img"> <img src="images/course/4.jpg" alt=""> <span class="home-list-pop-rat list-mi-pr">Duration:60 Days</span> </div>
                                                <div class="list-mig-lc-con">
                                                    <h5>Java Programming</h5>
                                                    <p>Illinois City,</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="list-mig-like-com com-mar-bot-30">
                                                <div class="list-mig-lc-img"> <img src="images/course/5.jpg" alt=""> <span class="home-list-pop-rat list-mi-pr">Duration:30 Days</span> </div>
                                                <div class="list-mig-lc-con">
                                                    <h5>Aeronautical Engineering</h5>
                                                    <p>Illinois City,</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="list-mig-like-com com-mar-bot-30">
                                                <div class="list-mig-lc-img"> <img src="images/course/3.jpg" alt=""> <span class="home-list-pop-rat list-mi-pr">Duration:20 Days</span> </div>
                                                <div class="list-mig-lc-con">
                                                    <h5>Master of Science</h5>
                                                    <p>Illinois City,</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                        <div class="udb-sec udb-cour-stat">
                            <h4><img src="images/icon/db3.png" alt="" /> Course Status</h4>
                            <p>Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.The point of using Lorem Ipsummaking it look like readable English.</p>
                            <div class="pro-con-table">
                                <table class="bordered responsive-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Course Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Edit</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>01</td>
                                            <td>Software Testing</td>
                                            <td>12May 2018</td>
                                            <td>18Aug 2018</td>
                                            <td><span class="pro-user-act">active</span></td>
                                            <td><a href="sdb-course-edit.html" class="pro-edit">edit</a></td>
                                            <td><a href="sdb-course-view.html" class="pro-edit">view</a></td>
                                        </tr>
                                        <tr>
                                            <td>02</td>
                                            <td>Mechanical Design</td>
                                            <td>05Jan 2019</td>
                                            <td>10Feb 2019</td>
                                            <td><span class="pro-user-act">active</span></td>
                                            <td><a href="sdb-course-edit.html" class="pro-edit">edit</a></td>
                                            <td><a href="sdb-course-view.html" class="pro-edit">view</a></td>
                                        </tr>
                                        <tr>
                                            <td>03</td>
                                            <td>Architecture & Planning</td>
                                            <td>21Jun 2020</td>
                                            <td>08Dec 2020</td>
                                            <td><span class="pro-user-act">active</span></td>
                                            <td><a href="sdb-course-edit.html" class="pro-edit">edit</a></td>
                                            <td><a href="sdb-course-view.html" class="pro-edit">view</a></td>
                                        </tr>
                                        <tr>
                                            <td>04</td>
                                            <td>Board Exam Training</td>
                                            <td>08Jun 2018</td>
                                            <td>21Sep 2018</td>
                                            <td><span class="pro-user-act pro-user-de-act">de-active</span></td>
                                            <td><a href="sdb-course-edit.html" class="pro-edit">edit</a></td>
                                            <td><a href="sdb-course-view.html" class="pro-edit">view</a></td>
                                        </tr>
                                        <tr>
                                            <td>05</td>
                                            <td>Yoga Training Classes</td>
                                            <td>16JFeb 2018</td>
                                            <td>26Mar 2018</td>
                                            <td><span class="pro-user-act pro-user-de-act">de-active</span></td>
                                            <td><a href="sdb-course-edit.html" class="pro-edit">edit</a></td>
                                            <td><a href="sdb-course-view.html" class="pro-edit">view</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row grey lighten-5" style="padding: 20px; height: auto;">
            <div class="container">
                
                <div class="col s12 m9">
                    <div class="grey lighten-4">

                        <div class="">
                            <h3 class="center-align">Bachelor of Science in Information Technology</h3>
                            <h5 class="center-align">Total Credits: 132</h5>

                            <table class="striped centered responsive-table">
                                <thead class="blue white-text">
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Courses</th>
                                        <th>Credits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr class="grey lighten-2">
                                        <td colspan="4"><strong>General Education Courses (30-40 credits)</strong></td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>English & Communication</td>
                                        <td>English Composition, Technical Writing, Public Speaking</td>
                                        <td>6-9</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Mathematics</td>
                                        <td>College Algebra, Discrete Mathematics, Statistics</td>
                                        <td>6-9</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Science</td>
                                        <td>Physics for IT, Computer Science Fundamentals</td>
                                        <td>6-8</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Social Sciences & Humanities</td>
                                        <td>Psychology, Ethics in IT, Business Management</td>
                                        <td>6-9</td>
                                    </tr>

                                    
                                    <tr class="grey lighten-2">
                                        <td colspan="4"><strong>Core IT Courses (60-70 credits)</strong></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Programming & Development</td>
                                        <td>Python, Java, Web Development, Mobile App Development</td>
                                        <td>15-18</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Database & Data Science</td>
                                        <td>SQL, NoSQL, Data Structures, Big Data Analytics</td>
                                        <td>9-12</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Networking & Security</td>
                                        <td>Computer Networks, Cybersecurity, Cloud Computing</td>
                                        <td>9-12</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Software Engineering & Systems</td>
                                        <td>Operating Systems, DevOps, System Analysis</td>
                                        <td>9-12</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>AI & Emerging Technologies</td>
                                        <td>Machine Learning, IoT, Blockchain</td>
                                        <td>6-9</td>
                                    </tr>

                                    
                                    <tr class="grey lighten-2">
                                        <td colspan="4"><strong>Electives & Capstone (15-20 credits)</strong></td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Elective Courses</td>
                                        <td>Game Development, AR/VR, Human-Computer Interaction</td>
                                        <td>9-12</td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>Capstone & Internship</td>
                                        <td>Senior Project, Internship</td>
                                        <td>6-8</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div> -->
    </section>
    <!--SECTION END-->
</x-layout>