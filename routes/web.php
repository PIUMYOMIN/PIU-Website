<?php

//Admin Controllers
use App\Http\Controllers\Admin\AdminAdmissionController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCourseCategoryController;
use App\Http\Controllers\Admin\AdminCourseCommentController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminDepartmentController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminEventRegisterController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminSlideController;
use App\Http\Controllers\Admin\AdminPositionController;
use App\Http\Controllers\Admin\AdminSeminarController;
use App\Http\Controllers\Admin\AdminTeamController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Admin\AdminModuleController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\Admin\AdminCurriculumController;
use App\Http\Controllers\Admin\AdminAssignmentController;
use App\Http\Controllers\Admin\StudentAssignmentController;
use App\Http\Controllers\Admin\SeminarEnrollController;
use App\Http\Controllers\Admin\AdminGradingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Spatie\Analytics\AnalyticsFacade as Analytics;

//User Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\User\AdmissionController;
use App\Http\Controllers\User\EventController;
use App\Http\Controllers\User\NewsController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\SeminarController;
use App\Http\Controllers\User\StudentController;
use App\Http\Controllers\User\JobController;
// use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', [HomeController::class, 'index']);

Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');
Route::post('/users/login/form/submit', [UserController::class, 'user_login'])->name('users.login.form.submit');

Route::get('/register', [UserController::class, 'register'])->middleware('guest')->name('register');
Route::post('/users/register/form/submit', [UserController::class, 'store'])->name('users.register.form.submit');

Route::get('/forgot-password',[UserController::class,'forget_password'])->name('forget-password');
Route::post('/forgot-password-form',[UserController::class,'forget_password_form'])->name('forget-password.form.submit');
Route::get('auth/passwords/password_reset_link_sent', [UserController::class, 'password_reset_link_successfull_sent']);
Route::get('/reset-password/{token}', [UserController::class, 'showResetPasswordForm']);
Route::patch('/reset-password/update', [UserController::class, 'forgotPasswordUpdate'])->name('forget-password.update');

Route::post('/admin/auth/logout', [UserController::class, 'logout'])->name('admin.auth.logout');
Route::post('/admin/student/logout', [UserController::class, 'studentLogout'])->name('admin.student.logout');

Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.index');

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {

//user details/delete
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user:id}/details', [UserController::class, 'show'])->name('users.details');
Route::delete('/users/{user:id}', [UserController::class, 'destroy'])->name('users.destroy');


//user role

Route::post('/user/{user:id}/roles', [UserController::class, 'assignRole'])->name('users.roles');
Route::delete('/user/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.removeRole');


//user permission

Route::post('/user/{user:id}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
Route::delete('/user/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revokePermission');


// Roles Routes

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roles/{role:id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::patch('/roles/{role:id}/update', [RoleController::class, 'update'])->name('roles.update');
Route::post('/roles/{role:id}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
Route::delete('/roles/{role:id}/permissions/{permission:id}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');


// Permission Routes

Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
Route::get('/permissions/{permission:id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::patch('/permissions/{permission:id}/update', [PermissionController::class, 'update'])->name('permissions.update');
Route::post('/permissions/{permission:id}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
Route::delete('/permissions/{permission:id}/role/{role:id}', [PermissionController::class, 'removeRole'])->name('permissions.roles.revoke');


// News Routes
Route::delete('/news/{new:slug}/delete', [AdminNewsController::class, 'destroy'])->name('news.delete');

// teams Routes
Route::get('/teams', [AdminTeamController::class, 'index'])->name('team.index');
Route::get('/teams/create', [AdminTeamController::class, 'create'])->name('team.create');
Route::post('/teams/form/submit', [AdminTeamController::class, 'store'])->name('team.form.submit');
Route::get('/teams/{slug}/edit', [AdminTeamController::class, 'edit'])->name('team.edit');
Route::patch('/teams/form/{slug}/update', [AdminTeamController::class, 'update'])->name('team.edit.form.submit');
Route::delete('/teams/{slug}/delete', [AdminTeamController::class, 'destroy'])->name('team.delete');


//Slider
Route::delete('/slides/{slide:id}/delete', [AdminSlideController::class, 'delete'])->name('slides.delete');


//course comment
Route::post('/course/comment/create', [AdminCourseCommentController::class, 'store'])->name('course.comment.create');
Route::patch('/course/comment/{comment:id}/update', [AdminCourseCommentController::class, 'update'])->name('course.comment.update');


//courses
Route::delete('/course/{course:id}/delete', [AdminCourseController::class, 'delete'])->name('course.delete');


//seminar
Route::delete('/seminar/{seminar:id}/delete', [AdminSeminarController::class, 'delete'])->name('seminar.delete');


//seminar enroll
Route::get('/seminar-enquiry', [SeminarEnrollController::class, 'index'])->name('seminar.enroll.index');
Route::post('/seminar/enroll/submit', [SeminarEnrollController::class, 'store'])->name('seminar.enroll.submit');


//event
Route::delete('/event/{event:id}/delete', [AdminEventController::class, 'delete'])->name('event.delete');

//event register
Route::get('/event-enquiry', [AdminEventRegisterController::class, 'index'])->name('event.register.index');
Route::post('/event/register/submit', [AdminEventRegisterController::class, 'store'])->name('event.register.submit');


//galleries
Route::delete('/gallery/{gallery:id}/delete', [AdminGalleryController::class, 'delete'])->name('gallery.delete');

//contact
Route::get('/contact-mails', [AdminContactController::class, 'index'])->name('contact.index');

//assignments 
Route::delete('/assignment/{assignment:id}/delete', [AdminAssignmentController::class, 'delete'])->name('assignment.delete');

});

Route::middleware(['auth', 'role:admin|registrar|faculty'])->name('admin.')->prefix('admin')->group(function () {
    //students
    Route::get('/students', [AdminStudentController::class, 'index'])->name('student.index');
    Route::get('/student/create', [AdminStudentController::class, 'create'])->name('student.create');
    Route::post('/student/store', [AdminStudentController::class, 'store'])->name('student.store');
    Route::get('/student/{id}/edit', [AdminStudentController::class, 'edit'])->name('student.edit');
    Route::patch('/student/{id}/update', [AdminStudentController::class, 'update'])->name('student.update');
    Route::post('/student/{student:id}/add_course', [AdminStudentController::class, 'addCourse'])->name('student.addCourse');
    Route::delete('/student/{student}/course/{year}/year/delete', [AdminStudentController::class, 'deleteCourse'])
    ->name('student.course.year.delete');
    Route::get('/students/study-course/{course_id}', [AdminStudentController::class,'filterCourse'])->middleware('auth');

    // assignment
    Route::get('/assignment/create', [AdminAssignmentController::class, 'create'])->name('assignment.create');
    Route::post('/assignment/store', [AdminAssignmentController::class, 'store'])->name('assignment.form.submit');
    Route::get('/assignment/{assignment:id}/edit', [AdminAssignmentController::class, 'edit'])->name('assignment.edit');
    Route::patch('/assignment/{assignment}/update', [AdminAssignmentController::class, 'update'])->name('assignment.update');
});


//Student profile
// Route::middleware('auth:student')->name('admin.')->prefix('admin')->group(function () {
//     Route::get('/profile', [StudentController::class, 'index'])->name('profile');
// });

// Route::middleware(['auth','role:admin|registrar'])->name('admin.')->prefix('admin')->group(function () {
    // });
Route::get('admin/student/profile/{identifier}', [StudentController::class, 'index'])->name('admin.student.profile');
Route::get('admin/student/profile/{identifier}/edit', [StudentController::class, 'edit'])->name('admin.student.profile.edit');
Route::get('admin/students/profile/{student:id}/details', [AdminStudentController::class, 'show'])->name('admin.students.profile.details');
Route::patch('admin/student/profile/{identifier}/update', [StudentController::class, 'update'])->name('admin.student.profile.update');
Route::get('/admin/student/profile/{identifier}/password-change', [AdminStudentController::class, 'changePassword'])->name('admin.student.profile.password-change');
Route::patch('/admin/student/profile/{identifier}/passwordUpdate', [AdminStudentController::class, 'passwordUpdate'])->name('admin.student.passwordUpdate');


// assignment for both admin, registrar and student
Route::get('/admin/assignments', [AdminAssignmentController::class, 'index'])->name('assignments');
Route::get('/admin/student/assignment/{slug}/details', [AdminAssignmentController::class, 'details'])->name('admin.student.assignment.details');
Route::get('/admin/student/assignment/{slug}/submit', [StudentAssignmentController::class, 'submit'])->name('admin.student.assignment.submit');
Route::post('/admin/student/assignment/{slug}/turn', [StudentAssignmentController::class, 'turn'])->name('admin.student.assignment.turn');
Route::get('/admin/student/assignments', [StudentAssignmentController::class, 'index'])->name('admin.student.assignments');


//Admin, Manager and Staff
Route::middleware(['auth', 'role:admin|manager|staff'])->name('admin.')->prefix('admin')->group(function () {

    //news
    Route::get('/news', [AdminNewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [AdminNewsController::class, 'create'])->name('news.create');
    Route::post('/news/form/submit', [AdminNewsController::class, 'store'])->name('news.form.submit');
    Route::get('/news/{id}/edit', [AdminNewsController::class, 'edit']);
    Route::patch('/news/form/{id}/update', [AdminNewsController::class, 'update'])->name('news.form.update');
    Route::resource('/news', App\Http\Controllers\Admin\AdminNewsController::class);

    //jobs
    Route::get('/jobs', [AdminJobController::class, 'index'])->middleware('auth')->name('jobs');
    Route::get('/jobs/create', [AdminJobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs/form/submit', [AdminJobController::class, 'store'])->name('jobs.form.submit');
    Route::get('/jobs/{id}/edit', [AdminJobController::class, 'edit'])->name('jobs.edit');
    Route::patch('/jobs/form/{id}/update', [AdminJobController::class, 'update'])->name('jobs.form.update');
    Route::delete('/jobs/{id}/delete', [AdminJobController::class, 'destroy'])->name('jobs.delete');
    // Route::resource('/jobs', App\Http\Controllers\Admin\AdminJobController::class);

    //galleries
    Route::get('/galleries', [AdminGalleryController::class, 'index'])->name('gallery.index');
    Route::get('/gallery/create', [AdminGalleryController::class, 'create'])->name('gallery.create');
    Route::post('/gallery/store', [AdminGalleryController::class, 'store'])->name('gallery.store');
    Route::get('/gallery/{gallery:id}/edit', [AdminGalleryController::class, 'edit'])->name('gallery.edit');
    Route::patch('/gallery/{gallery:id}/update', [AdminGalleryController::class, 'update'])->name('gallery.update');


    //seminars
    Route::get('/seminars', [AdminSeminarController::class, 'index'])->name('seminar.index');
    Route::get('/seminar/create', [AdminSeminarController::class, 'create'])->name('seminar.create');
    Route::post('/seminar/store', [AdminSeminarController::class, 'store'])->name('seminar.store');
    Route::get('/seminar/{seminar:id}/edit', [AdminSeminarController::class, 'edit'])->name('seminar.edit');
    Route::patch('/seminar/{seminar:id}/update', [AdminSeminarController::class, 'update'])->name('seminar.update');


    //slide
    Route::get('/slides', [AdminSlideController::class, 'index'])->name('slide');
    Route::get('/slides/create', [AdminSlideController::class, 'create'])->name('slides.create');
    Route::post('/slides/store', [AdminSlideController::class, 'store'])->name('slides.store');
    Route::get('/slides/details/{id}', [AdminSlideController::class, 'show'])->name('slides.show');
    Route::get('/slides/{slide:id}/edit', [AdminSlideController::class, 'edit'])->name('slides.edit');
    Route::patch('/slides/{slide:id}/update', [AdminSlideController::class, 'update'])->name('slides.update');
    Route::patch('/slide/{slide:id}/isActive', [AdminSlideController::class, 'isActive'])->name('slide.isActive');


    //course category
    Route::get('/course-categories', [AdminCourseCategoryController::class, 'index'])->name('category');
    Route::get('/course-category/create', [AdminCourseCategoryController::class, 'create'])->name('course-category.create');
    Route::post('/course/category/create', [AdminCourseCategoryController::class, 'store'])->name('course.category.create');
    Route::get('/course/category/{category:id}/edit', [AdminCourseCategoryController::class, 'edit'])->name('course.category.edit');
    Route::patch('/course/category/{category:id}/update', [AdminCourseCategoryController::class, 'update'])->name('course.category.update');
    Route::get('/course/category/{category:id}/edit', [AdminCourseCategoryController::class, 'edit'])->name('course.category.edit');


    //event
    Route::get('/events', [AdminEventController::class, 'index'])->name('event.index');
    Route::get('/event/create', [AdminEventController::class, 'create'])->name('event.create');
    Route::post('/event/store', [AdminEventController::class, 'store'])->name('event.store');
    Route::get('/event/{event:id}/edit', [AdminEventController::class, 'edit'])->name('event.edit');
    Route::patch('/event/{event:id}/update', [AdminEventController::class, 'update'])->name('event.update');

    //curriculums
    Route::get('/curriculums', [AdminCurriculumController::class, 'index'])->name('curriculum.index');
    Route::get('/curriculum/create', [AdminCurriculumController::class, 'create'])->name('curriculum.create');
    Route::post('/curriculum/store', [AdminCurriculumController::class, 'store'])->name('curriculum.store');
    Route::get('/curriculum/{curriculum:id}/edit', [AdminCurriculumController::class, 'edit'])->name('curriculum.edit');
    Route::patch('/curriculum/{curriculum:id}/update', [AdminCurriculumController::class, 'index'])->name('curriculum.update');
    Route::delete('/curriculum/{curriculum:id}/delete', [AdminCurriculumController::class, 'delete'])->name('curriculum.delete');

});

Route::middleware('auth')->name('admin.')->prefix('admin')->group(function(){
    Route::get('/users/profile/{user}/edit', [UserController::class, 'editUserProfile'])->name('users.profile.edit');
    Route::patch('/users/{user:id}/edit/form/submit', [UserController::class, 'update'])->name('users.edit.form.submit');
    Route::get('/users/password-change/{user:id}', [UserController::class, 'passwordChange'])->name('users.password-change');
    Route::post('/users/passwordUpdate/{user:id}', [UserController::class, 'passwordUpdate'])->name('users.passwordUpdate');
    Route::get('/users/{user:id}/update', [UserController::class, 'update'])->name('user.update');
});

//admin, manager, staff, registrar

Route::middleware(['auth', 'role:admin|manager|staff|registrar|faculty'])->name('admin.')->prefix('admin')->group(function () {
    //admission
    Route::get('/admission/application-forms', [AdminAdmissionController::class, 'index'])->name('admission.forms');
    Route::get('/admissions/filter/{courseId}', [AdminAdmissionController::class, 'filterByCourse']);

    // student grading
    Route::get('students/grading/create', [AdminGradingController::class, 'index'])->name('students.grading.create');
    Route::get('students/grading/check', [AdminGradingController::class, 'viewGrading']);
    Route::get('/students/grading/study-course/{course_id}', [AdminGradingController::class,'filterCourse'])->middleware('auth');

    //first semester
    Route::get('students/first_semester/grading/add/{student:id}/{semester_id}', [AdminGradingController::class, 'firstSemesterGradingAdd'])->name('students.first_semester.grading.add');
    Route::post('students/first_semester/grading/create/{student}/{semester_id}', [AdminGradingController::class, 'storeFirstSemester'])->name('students.grades.storeFirstSemester');
    Route::get('students/first_semester/grading/view/{student:id}/{semester}', [AdminGradingController::class, 'firstSemesterGrading'])->name('students.first_semester.grading.view');

    //second semester
    Route::get('students/second_semester/grading/add/{student:id}/{semester_id}', [AdminGradingController::class, 'secondSemesterGradingAdd'])->name('students.second_semester.grading.add');
    Route::post('students/second_semester/grading/create/{student}/{semester_id}', [AdminGradingController::class, 'storeSecondSemester'])->name('students.grades.storeSeconodSemester');
    Route::get('students/second_semester/grading/view/{student:id}/{semester}', [AdminGradingController::class, 'secondSemesterGrading'])->name('students.second_semester.grading.view');

    //grading edit
    Route::get('student/{student}/grading/{grading}/semester/{semester}/edit',[AdminGradingController::class,'edit'])->name('student.grading.edit');
    Route::put('student/{student}/grading/{grading}/semester/{semester}', [AdminGradingController::class, 'update'])->name('student.grading.update');

});

//admin, manager, staff
Route::middleware(['auth', 'role:admin|manager|staff|registrar'])->name('admin.')->prefix('admin')->group(function () {

//course
    Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
    Route::post('/courses/store', [AdminCourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course:id}/edit', [AdminCourseController::class, 'edit'])->name('courses.edit');
    Route::patch('/courses/{course:id}/update', [AdminCourseController::class, 'update'])->name('courses.update');
    Route::patch('/courses/{course:id}/isActive', [AdminCourseController::class, 'isActive'])->name('courses.isActive');
    Route::patch('/courses/{course:id}/application', [AdminCourseController::class, 'application'])->name('courses.application');


//department
    Route::get('/departments', [AdminDepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/create', [AdminDepartmentController::class, 'create'])->name('department.create');
    Route::post('/department/store', [AdminDepartmentController::class, 'store'])->name('department.form.submit');
    Route::get('/department/{department:id}/edit', [AdminDepartmentController::class, 'edit'])->name('department.edit');
    Route::patch('/department/{department:id}/update', [AdminDepartmentController::class, 'update'])->name('department.update');


//position
    Route::get('/positions', [AdminPositionController::class, 'index'])->name('position.index');
    Route::get('/position/create', [AdminPositionController::class, 'create'])->name('position.create');
    Route::post('/position/store', [AdminPositionController::class, 'store'])->name('position.form.submit');
    Route::get('/position/{position:id}/edit', [AdminPositionController::class, 'edit'])->name('position.edit');
    Route::patch('/position/{position:id}/update', [AdminPositionController::class, 'update'])->name('position.update');


//seminar
    Route::get('/seminars', [AdminSeminarController::class, 'index'])->name('seminar.index');
    Route::get('/seminar/create', [AdminSeminarController::class, 'create'])->name('seminar.create');
    Route::post('/seminar/store', [AdminSeminarController::class, 'store'])->name('seminar.store');
    Route::get('/seminar/{seminar:id}/edit', [AdminSeminarController::class, 'edit'])->name('seminar.edit');
    Route::patch('/seminar/{seminar:id}/update', [AdminSeminarController::class, 'update'])->name('seminar.update');

//module
    Route::get('/modules', [AdminModuleController::class, 'index'])->name('modules.index');
    Route::get('/module/create', [AdminModuleController::class, 'create'])->name('module.create');
    Route::post('/module/store', [AdminModuleController::class, 'store'])->name('module.store');
    Route::get('/module/{module:id}/edit', [AdminModuleController::class, 'edit'])->name('module.edit');
    Route::patch('/module/{module:id}/update', [AdminModuleController::class, 'update'])->name('module.update');
    Route::delete('/module/{module:id}/delete', [AdminModuleController::class, 'destroy'])->name('module.delete');

//module
    Route::get('/subjects', [AdminSubjectController::class, 'index'])->name('subjects.index');
    Route::get('/subjects/create', [AdminSubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects/store', [AdminSubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/{id}/edit', [AdminSubjectController::class, 'edit'])->name('subjects.edit');
    Route::patch('/subjects/{id}/update', [AdminSubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{subject:id}/delete', [AdminSubjectController::class, 'destroy'])->name('subjects.delete');
});

//course
Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
Route::get('/courses/{slug}', [CourseController::class, 'show']);
Route::post('/search-course',[AdminCourseController::class,'search'])->name('search-course');

//news
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);

//teams
Route::get('/teams', [TeamController::class, 'index']);
Route::get('/teams/{slug}', [TeamController::class, 'show']);

//seminar
Route::get('/seminars/{seminar:slug}', [SeminarController::class, 'show'])->name('seminar.show');

//event
Route::get('/events', [EventController::class, 'index'])->name('event.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('event.show');
Route::get('/events/{slug}/register', [EventController::class, 'register'])->name('events.register');

//job
Route::get('/jobs', [JobController::class, 'index'])->name('job.index');
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('job.show');


//Contact Form
Route::get('/contact-us', [ContactController::class, 'index']);
Route::post('/contact/form/submit', [ContactController::class, 'store'])->name('contact.form.submit');

//Admission
Route::get('/piu/admission/application-form', [AdmissionController::class, 'create']);
Route::post('/piu/application/first-form', [AdmissionController::class, 'storeFirst'])->name('piu.application.first-form');
Route::get('/piu/application/second-form', [AdmissionController::class, 'second']);
Route::post('/piu/application/second-form', [AdmissionController::class, 'storeSecond'])->name('piu.application.second-form');
Route::get('/piu/admission/application-form-successfully-submited/{token}', [AdmissionController::class, 'success']);
Route::get('/admin/admissions/{admission:id}/details', [AdmissionController::class, 'show']);

// google login
Route::get('/auth/google/user/redirect', [UserController::class, 'redirectToGoogle'])->name('auth.google.user.redirect');
Route::get('/auth/google/user/callback', [UserController::class, 'googleCallback'])->name('googleCallback');

//facebook login
Route::get('/auth/facebook/user/redirect', [UserController::class, 'redirectToFacebook'])->name('auth.facebook.user.redirect');
Route::get('/auth/facebook/user/callback', [UserController::class, 'facebookCallback'])->name('facebookCallback');

//twitter login
Route::get('/auth/twitter/user/redirect', [UserController::class, 'redirectToTwitter'])->name('auth.twitter.user.redirect');
Route::get('/auth/twitter/user/callback', [UserController::class, 'twitterCallback'])->name('twitterCallback');

Route::get('/about-us', function () {
    return view('user.about.index');
});

Route::get('/president-of-piu',function () {
    return view('user.about.president');
});

Route::get('/pravicy-policy',function () {
    return view('user.pravicy.index');
});

Route::get('/checkUserRole', [UserController::class, 'checkUserRole']);

Route::get('/data',function(){
    $analyticsData = Analytics::trackPageView();

    dd($analyticsData[0]['pageViews']);
});

Route::any('{any}',function(){
    return view('error.404');
})->where('any','.*');