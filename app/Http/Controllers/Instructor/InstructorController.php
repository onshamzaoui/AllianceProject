<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    public function CoursesPage()
    {
        if (!Auth::guard('Instructor')->user()) {
            return redirect("/login");
        }

        $connecteduser = Auth::guard('Instructor')->user();


        $programs = Program::where("instructor_id", $connecteduser->id)->get();


        return view('instructor/courses', [
            'connecteduser' => $connecteduser,
            "programs" => $programs
        ]);
    }
    public function show(Course $course)
    {
        return view('courses.show', compact($course));
    }
    public function editCourse(Request $request)
    {
        if (!Auth::guard('Instructor')->user()) {
            return redirect("/login");
        }

        $id = $request->route("id");


        $connecteduser = Auth::guard('Instructor')->user();

        $program = Program::where("id", $id)->first();

        return view('instructor/ModifyCourse', [
            'program' => $program

        ]);
    }

    public function updateAProgram(Request $request)
    {
        Program::where('id', $request->id)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => intval($request->price),
                'difficulty' => $request->difficulty

            ]);


        return redirect("/instructor/courses");
    }






    public function addCourse(Request $request, Course $course)
    {
        if (!Auth::guard('Instructor')->user()) {
            return redirect("/login");
        }



        $connecteduser = Auth::guard('Instructor')->user();



        return view('instructor/AddCourse', [

            'connecteduser' => $connecteduser,
        ]);
    }


    public function addNewProgram(Request $request)
    {
        $connecteduser = Auth::guard('Instructor')->user();

        $selectedfile = $request->file("image");
        $filename = time() . $selectedfile->getClientOriginalName();


        Storage::disk('public_uploads')->put($filename, file_get_contents($selectedfile));




        $program = new Program();



        $program->title = $request->title;
        $program->description = $request->description;
        $program->price = $request->price;
        $program->difficulty = $request->difficulty;
        $program->image = $filename;
        $program->validation = "non validated";
        $program->percentege = $request->percentege;
        $program->instructor_id = $connecteduser->id;

        $program->save();

        return redirect("/instructor/courses");
    }





    public function deleteCourse(Request $request)
    {


        Program::where("id", $request->id)->delete();

        return redirect("/instructor/courses");
    }



    //profile

    public function viewProfile()
    {
        if (!Auth::guard('Instructor')->user()) {
            return redirect("/login");
        }



        $connecteduser = Auth::guard('Instructor')->user();



        return view('instructor/profile', [

            'connecteduser' => $connecteduser,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $connecteduser = Auth::guard('Instructor')->user();
        if($request->has("profilemanagement")){

            
                    $selectedfile = $request->file("image");
                    if ($selectedfile) {
                        $filename = time() . $selectedfile->getClientOriginalName();
                        Storage::disk('public_uploads')->put($filename, file_get_contents($selectedfile));
            
                        Instructor::where('id', $connecteduser->id)
                            ->update([
                                'first_name' => $request->first_name,
                                'last_name' => $request->last_name,
                                'company' => $request->company,
                                'image' => $filename
            
                            ]);
                    } else {
                        Instructor::where('id', $connecteduser->id)
                            ->update([
                                'first_name' => $request->first_name,
                                'last_name' => $request->last_name,
                                'company' => $request->company,
            
                            ]);
                    }
        }


        if($request->has("passwordmanagement")){
            if($request->newpassword == $request->newpasswordconfirmation){
                Instructor::where('id', $connecteduser->id)
                    ->update([
                        'password' => bcrypt($request->newpassword)
                    ]);
            }
        }


        return redirect("/instructor/profile");
    }








    //Item management => COurses


    public function ItemsPage(Request $request)
    {
        $connecteduser = Auth::guard('Instructor')->user();

        


        if($request->route("program")){
            dd($request->route("program"));
            $items = DB::table('course')
            ->join('program', 'course.program_id', '=', 'program.id')
            ->join('instructor', 'program.instructor_id', '=', 'instructor.id')
            ->where([
                ['program.id', '=', $request->route("program_id")],
                ['instructor.id', '=', $connecteduser->id]
            ])
            ->select("course.*", "program.title")
            ->get();    
        }else{

            $items = DB::table('course')
            ->join('program', 'course.program_id', '=', 'program.id')
            ->join('instructor', 'program.instructor_id', '=', 'instructor.id')
            ->where("instructor.id", $connecteduser->id)
            ->select("course.*", "program.title")
            ->get();
        }
            
            
        $programs = Program::where("instructor_id", $connecteduser->id)->get();


        return view('instructor/items', [
            "items" => $items,
            'connecteduser' => $connecteduser,
            "programs" => $programs
        ]);
    }




    public function AddItemHomePage(Request $request)
    {
        $selectedprogramid = $request->id;






        $connecteduser = Auth::guard('Instructor')->user();


        $programs = Program::where("instructor_id", $connecteduser->id)->get();



        return view('instructor/AddItem', [
            'selectedprogramid' => $selectedprogramid,
            'connecteduser' => $connecteduser,
            'programs' => $programs,
        ]);
    }


    public function AddNewItem(Request $request)
    {

        $item = new Course();

        $item->name = $request->name;
        $item->description = $request->description;
        $item->program_id = $request->program;



        $item->save();


        return redirect("/instructor/courses");
    }


    public function editItem(Request $request)
    {
        if (!Auth::guard('Instructor')->user()) {
            return redirect("/login");
        }

        $id = $request->route("id");


        $connecteduser = Auth::guard('Instructor')->user();

        $item = Course::where("id", $id)->first();

        return view('instructor/ModifyItem', [
            'item' => $item

        ]);
    }

    public function updateItem(Request $request)
    {
        Course::where('id', $request->id)
            ->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);



        return redirect("/instructor/items");
    }




    public function ViewItem(Request $request){
        $connecteduser = Auth::guard('Instructor')->user();



        $item = Course::where('id', $request->route("id"))->first();
        
        $contents = Content::where('course_id', $request->route("id"))->get();




        return view('instructor/Item', [
            'item' => $item,
            'contents' => $contents,
            'connecteduser' => $connecteduser,
        ]);
        
    }


    public function ContentPage(Request $request){
        $connecteduser = Auth::guard('Instructor')->user();

        $item = Course::where("id" , $request->id)->first();





        return View("instructor/AddContent" , [
            'item' => $item,
            'connecteduser' => $connecteduser,

        ]);



    }


    public function AddNewContent(Request $request){
        
        $connecteduser = Auth::guard('Instructor')->user();

        
        $selectedfile = $request->file("content");

        $filename = time() . $selectedfile->getClientOriginalName();


        Storage::disk('public_uploads')->put($filename, file_get_contents($selectedfile));


        $content = new Content();
        $content->type = $request->type;
        $content->content = $filename;
        $content->course_id = $request->item;
        $content->chapter = $request->chapter;


        $content->save();

        return redirect("/instructor/item/".$request->item);


    }


    public function ViewContent(Request $request){
        $content = Content::where("id" , $request->route("id"))->first();


        return View("instructor/ContentPreview" , [
            'content' => $content,
        ]);
    }



}
