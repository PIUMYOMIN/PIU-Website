<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Spatie\Analytics\Period;
use Spatie\Analytics\Facades\Analytics;

//Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminCourseCategoryController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminCourseCommentController;
use App\Http\Controllers\Admin\AdminSlideController;
use App\Http\Controllers\Admin\AdminDepartmentController;
use App\Http\Controllers\Admin\AdminPositionController;
use App\Http\Controllers\Admin\AdminSeminarController;
use App\Http\Controllers\Admin\SeminarEnrollController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminTeamController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminEventRegisterController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

//User Controllers
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\NewsController;
use App\Http\Controllers\User\CourseController;
use App\Http\Controllers\User\SeminarController;
use App\Http\Controllers\User\EventController;

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

Route::get('/', [HomeController::class,'index']);

Route::get('/login',[UserController::class,'login'])->middleware('guest');
Route::post('/user/login/form/submit',[UserController::class,'user_login'])->name('user.login.form.submit');

Route::get('/register',[UserController::class,'register'])->middleware('guest')->name('admin.auth.register');
Route::post('/user/register/form/submit',[UserController::class,'store'])->name('user.register.form.submit');

Route::post('/admin/auth/logout',[UserController::class,'logout'])->name('admin.auth.logout');



Route::get('/admin',[AdminController::class,'index'])->middleware('auth')->name('index');

Route::middleware(['auth','role:admin|writer|user'])->name('admin.')->prefix('admin')->group(function(){
  // User Routes
  Route::get('/users',[UserController::class,'index'])->name('users.index');
  Route::get('/user/{user:id}/details',[UserController::class,'show'])->name('user.details');
  Route::get('/user/{user:id}/update',[UserController::class,'update'])->name('user.update');
  Route::delete('/user/{user:id}',[UserController::class,'destroy'])->name('user.destroy');
  Route::get('/user/password-change/{user:id}',[UserController::class,'passwordChange'])->name('user.password-change');
  Route::post('/user/passwordUpdate/{user:id}',[UserController::class,'passwordUpdate'])->name('user.passwordUpdate');

  //user role
  Route::post('/user/{user:id}/roles',[UserController::class,'assignRole'])->name('user.roles');
  Route::delete('/user/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('user.roles.removeRole');

  //user permission
  Route::post('/user/{user:id}/permissions',[UserController::class,'givePermission'])->name('user.permissions');
  Route::delete('/user/{user}/permissions/{permission}',[UserController::class,'revokePermission'])->name('user.permissions.revokePermission');

  // Roles Routes
  Route::get('/roles',[RoleController::class,'index'])->name('roles.index');
  Route::get('/roles/create',[RoleController::class,'create'])->name('roles.create');
  Route::post('/roles/store',[RoleController::class,'store'])->name('roles.store');
  Route::get('/roles/{role:id}/edit',[RoleController::class,'edit'])->name('roles.edit');
  Route::patch('/roles/{role:id}/update',[RoleController::class,'update'])->name('roles.update');
  Route::post('/roles/{role:id}/permissions',[RoleController::class,'givePermission'])->name('roles.permissions');
  Route::delete('/roles/{role:id}/permissions/{permission:id}',[RoleController::class,'revokePermission'])->name('roles.permissions.revoke');

  // Permission Routes
  Route::get('/permissions',[PermissionController::class,'index'])->name('permissions.index');
  Route::get('/permissions/create',[PermissionController::class,'create'])->name('permissions.create');
  Route::post('/permissions/store',[PermissionController::class,'store'])->name('permissions.store');
  Route::get('/permissions/{permission:id}/edit',[PermissionController::class,'edit'])->name('permissions.edit');
  Route::patch('/permissions/{permission:id}/update',[PermissionController::class,'update'])->name('permissions.update');
  Route::post('/permissions/{permission:id}/roles',[PermissionController::class,'assignRole'])->name('permissions.roles');
  Route::delete('/permissions/{permission:id}/role/{role:id}',[PermissionController::class,'removeRole'])->name('permissions.roles.revoke');

  // News Routes
  Route::get('/news',[AdminNewsController::class,'index'])->name('news.index');
  Route::get('/news/create',[AdminNewsController::class,'create'])->name('news.create');
  Route::post('/news/form/submit',[AdminNewsController::class,'store'])->name('news.form.submit');
  Route::get('/news/{new:slug}/edit',[AdminNewsController::class,'edit'])->name('news.edit');
  Route::patch('/news/form/{new:slug}/update',[AdminNewsController::class,'update'])->name('news.form.update');
  Route::delete('/news/{new:slug}/delete',[AdminNewsController::class,'destroy'])->name('news.delete');

  // teams Routes
  Route::get('/teams',[AdminTeamController::class,'index'])->name('team.index');
  Route::get('/team/create',[AdminTeamController::class,'create'])->name('team.create');
  Route::post('/team/form/submit',[AdminTeamController::class,'store'])->name('team.form.submit');
  Route::get('/team/{team:id}/edit',[AdminTeamController::class,'edit'])->name('team.edit');
  Route::patch('/team/form/{team:id}/update',[AdminTeamController::class,'update'])->name('team.edit.form.submit');
  Route::delete('/team/{team:id}/delete',[AdminTeamController::class,'destroy'])->name('team.delete');

  //Slider
  Route::get('/slides', [AdminSlideController::class,'index'])->name('slide');
  Route::get('/slides/create', [AdminSlideController::class,'create'])->name('slides.create');
  Route::post('/slides/store', [AdminSlideController::class,'store'])->name('slides.store');
  Route::get('/slides/{slide:id}/edit', [AdminSlideController::class,'edit'])->name('slides.edit');
  Route::patch('/slides/{slide:id}/update', [AdminSlideController::class,'update'])->name('slides.update');
  Route::patch('/slides/{slide:id}/isActive', [AdminSlideController::class,'isActive'])->name('slides.isActive');
  Route::delete('/slides/{slide:id}/delete', [AdminSlideController::class,'delete'])->name('slides.delete');

  //course category
  Route::get('/course-categories', [AdminCourseCategoryController::class,'index'])->name('category');
  Route::get('/course-category/create', [AdminCourseCategoryController::class,'create'])->name('course-category.create');
  Route::post('/course/category/create', [AdminCourseCategoryController::class,'store'])->name('course.category.create');
  Route::get('/course/category/{category:id}/edit', [AdminCourseCategoryController::class,'edit'])->name('course.category.edit');
  Route::patch('/course/category/{category:id}/update', [AdminCourseCategoryController::class,'update'])->name('course.category.update');

  //course comment
  Route::post('/course/comment/create', [AdminCourseCommentController::class,'store'])->name('course.comment.create');
  Route::get('/course/category/{category:id}/edit', [AdminCourseCommentController::class,'edit'])->name('course.comment.edit');
  Route::patch('/course/category/{comment:id}/update', [AdminCourseCommentController::class,'update'])->name('course.comment.update');

  //courses
  Route::delete('/course/{course:id}/delete', [AdminCourseController::class,'delete'])->name('course.delete');

  //seminar
  Route::get('/seminars', [AdminSeminarController::class,'index'])->name('seminar.index');
  Route::get('/seminar/create', [AdminSeminarController::class,'create'])->name('seminar.create');
  Route::post('/seminar/store', [AdminSeminarController::class,'store'])->name('seminar.store');
  Route::get('/seminar/{seminar:id}/edit', [AdminSeminarController::class,'edit'])->name('seminar.edit');
  Route::patch('/seminar/{seminar:id}/update', [AdminSeminarController::class,'update'])->name('seminar.update');
  Route::delete('/seminar/{seminar:id}/delete', [AdminSeminarController::class,'delete'])->name('seminar.delete');

    //seminar enroll
  Route::get('/seminar-enquiry',[SeminarEnrollController::class,'index'])->name('seminar.enroll.index');
  Route::post('/seminar/enroll/submit',[SeminarEnrollController::class,'store'])->name('seminar.enroll.submit');

  //event
  Route::get('/events', [AdminEventController::class,'index'])->name('event.index');
  Route::get('/event/create', [AdminEventController::class,'create'])->name('event.create');
  Route::post('/event/store', [AdminEventController::class,'store'])->name('event.store');
  Route::get('/event/{event:id}/edit', [AdminEventController::class,'edit'])->name('event.edit');
  Route::patch('/event/{event:id}/update', [AdminEventController::class,'update'])->name('event.update');
  Route::delete('/event/{event:id}/delete', [AdminEventController::class,'delete'])->name('event.delete');

  //event register
  Route::get('/event-enquiry',[AdminEventRegisterController::class,'index'])->name('event.register.index');
  Route::post('/event/register/submit',[AdminEventRegisterController::class,'store'])->name('event.register.submit');

    //galleries
  Route::get('/galleries', [AdminGalleryController::class,'index'])->name('gallery.index');
  Route::get('/gallery/create', [AdminGalleryController::class,'create'])->name('gallery.create');
  Route::post('/gallery/store', [AdminGalleryController::class,'store'])->name('gallery.store');
  Route::get('/gallery/{gallery:id}/edit', [AdminGalleryController::class,'edit'])->name('gallery.edit');
  Route::patch('/gallery/{gallery:id}/update', [AdminGalleryController::class,'update'])->name('gallery.update');
  Route::delete('/gallery/{gallery:id}/delete', [AdminGalleryController::class,'delete'])->name('gallery.delete');

  //contact
  Route::get('/contact-mails',[AdminContactController::class,'index'])->name('contact.index');

});

//all user
Route::middleware(['auth'])->name('admin.')->prefix('admin')->group(function(){
      Route::get('/user/profile/{user}/edit', [UserController::class, 'editUserProfile'])->name('user.profile.edit');
      Route::patch('/user/{user:id}/edit/form/submit',[UserController::class,'update'])->name('user.edit.form.submit');
});

//admin, manager, staff
Route::middleware(['auth','role:admin|manager|staff'])->name('admin.')->prefix('admin')->group(function(){

      //course
      Route::get('/courses', [AdminCourseController::class,'index'])->name('course.index');
      Route::get('/course/create', [AdminCourseController::class,'create'])->name('course.create');
      Route::post('/course/store', [AdminCourseController::class,'store'])->name('course.store');
      Route::get('/course/{course:id}/edit', [AdminCourseController::class,'edit'])->name('course.edit');
      Route::patch('/course/{course:id}/update', [AdminCourseController::class,'update'])->name('course.update');
      Route::patch('/course/{course:id}/isActive', [AdminCourseController::class,'isActive'])->name('course.isActive');

      //department
      Route::get('/departments', [AdminDepartmentController::class,'index'])->name('department.index');
      Route::get('/department/create', [AdminDepartmentController::class,'create'])->name('department.create');
      Route::post('/department/store', [AdminDepartmentController::class,'store'])->name('department.form.submit');
      Route::get('/department/{department:id}/edit', [AdminDepartmentController::class,'edit'])->name('department.edit');
      Route::patch('/department/{department:id}/update', [AdminDepartmentController::class,'update'])->name('department.update');

      //position
      Route::get('/positions', [AdminPositionController::class,'index'])->name('position.index');
      Route::get('/position/create', [AdminPositionController::class,'create'])->name('position.create');
      Route::post('/position/store', [AdminPositionController::class,'store'])->name('position.form.submit');
      Route::get('/position/{position:id}/edit', [AdminPositionController::class,'edit'])->name('position.edit');
      Route::patch('/position/{position:id}/update', [AdminPositionController::class,'update'])->name('position.update');
});

//course
Route::get('/courses',[CourseController::class,'index']);
Route::get('/courses/{slug}',[CourseController::class,'show'])->name('courses.show');

//news
Route::get('/news',[NewsController::class,'index'])->name('news.index');
Route::get('/news/{slug}',[NewsController::class,'show'])->name('news.show');

//seminar
Route::get('/seminars/{seminar:slug}',[SeminarController::class, 'show'])->name('seminar.show');

//event
Route::get('/events',[EventController::class, 'index'])->name('event.index');
Route::get('/events/{event:slug}',[EventController::class, 'show'])->name('event.show');
Route::get('/events/{slug}/register', [EventController::class, 'register'])->name('events.register');

//Contact Form
Route::get('/contact',[ContactController::class,'index']);
Route::post('/contact/form/submit',[ContactController::class,'store'])->name('contact.form.submit');

//api
Route::get('/data',function(){
  $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
  dd($analyticsData);
});

// google login
Route::get('/auth/google/user/redirect', [UserController::class,'redirectToGoogle'])->name('auth.google.user.redirect');
Route::get('/auth/google/user/callback', [UserController::class,'googleCallback'])->name('googleCallback');

//facebook login
Route::get('/auth/facebook/user/redirect', [UserController::class,'redirectToFacebook'])->name('auth.facebook.user.redirect');
Route::get('/auth/facebook/user/callback', [UserController::class,'facebookCallback'])->name('facebookCallback');

//twitter login
Route::get('/auth/twitter/user/redirect', [UserController::class,'redirectToTwitter'])->name('auth.twitter.user.redirect');
Route::get('/auth/twitter/user/callback', [UserController::class,'twitterCallback'])->name('twitterCallback');

Route::get('/about-us',function(){
  return view('user.about.index');
});

Route::get('/president-of-piu',function(){
  return view('user.about.president');
});

Route::get('/pravicy-policy',function(){
  return view('user.pravicy.index');
});