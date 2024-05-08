<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\User;

class AdminCourseController extends Controller
{
    public function index()
    {
       return view('admin.courses.index',[
        'courses' => Course::all(),
        'category' => CourseCategory::all(),
        'user' => User::all(),
       ]);
    }

    public function create()
    {
        return view('admin.courses.create',[
            'categories' => CourseCategory::all(),
        ]);
    }

    public function store(Request $request)
    {

       $data = request()->validate([
        'title' => ['required',Rule::unique('courses','title')],
        'description' => 'required',
        'eligibility' => 'required',
        'requirement' => 'required',
        'fees' => 'required',
        'apply' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'duration' => 'required',
        'total_seat' => 'required',
        'ic_name' => 'required',
        'ic_phone' => 'required',
        'course_category_id' => 'required',
        'image' => 'required|image|mimes:png,jpg,jpeg'
       ]);

       $data['slug'] = Str::slug($data['title']);

       if($request->hasFile('image')){
            $filePatch = $request->file('image')->store('course_images','public');
            $data['image'] = $filePatch;
       }

       $data['user_id'] = auth()->user()->id;

       Course::create($data);

       return redirect('/admin/courses');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit',[
            'course' => $course,
            'categories' => CourseCategory::all(),
        ]);
    }

    public function update(Request $request, Course $course)
    {
       $data = request()->validate([
        'title' => ["required",Rule::unique('courses','title')->ignore($course->id)],
        'description' => 'required',
        'eligibility' => 'required',
        'requirement' => 'required',
        'fees' => 'required',
        'apply' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'duration' => 'required',
        'total_seat' => 'required',
        'ic_name' => 'required',
        'ic_phone' => 'required',
        'course_category_id' => 'required',
        'image' => 'nullable|image|mimes:png,jpg,jpeg'
       ]);

       $data['slug'] = Str::slug($data['title']);

       if($request->hasFile('image')){
            $filePatch = $request->file('image')->store('course_images','public');
            $data['image'] = $filePatch;
       }else{
        $data['image'] = $course->image;
       }

       $data['user_id'] = auth()->user()->id;

       $course->update($data);

       return redirect('/admin/courses');
    }

    public function delete(Course $course)
    {
        $course->delete();

        return redirect()->back();
    }

    public function isActive(Request $request, Course $course)
    {
        $course->update(['is_active' => !$course->is_active]);

        return redirect()->back();
    }

    public function application(Request $request, Course $course)
    {
        $course->update(['application_sts' => !$course->application_sts]);

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $courses = Course::where('title', 'like', "%$searchTerm%")->get();

        return view('user.courses.search_course',[
            'courses' => $courses
        ]);
    }

    public function uploadImage(Request $request)
    {
        if($request->hasfile('upload')){
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_'. time(). '.'.$extension;
            $request->file('upload')->move(public_path('courses'),$fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('courses/'.$fileName);
            $msg = 'Image successfully uploaded';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>"; 
            // return responce()->json(['fileName' => $filename, 'uploaded'=>1, 'url'=>$url]);
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    } 
}