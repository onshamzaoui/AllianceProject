<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use \PDF;




class AgentController extends Controller
{
    public function index()
    {
        if (!Auth::guard('Agent')->user()) {
            return redirect("/login");
        }

        $connecteduser = Auth::guard('Agent')->user();

        $programs = Program::all();
        $instructors = Instructor::all();
        $validatedprograms = Program::where("validation", "validated")->get();



        return view('agent/agent', [
            'connecteduser' => $connecteduser,
            "programs" => $programs,
            "instructors" => $instructors,
            "validatedprograms" => $validatedprograms
        ]);
    }


    public function ProgramsHomePage()
    {
        if (!Auth::guard('Agent')->user()) {
            return redirect("/login");
        }

        $connecteduser = Auth::guard('Agent')->user();

        $programs = Program::where("validation", "non validated")->get();



        foreach ($programs as $program) {
            $program->course = Course::where("program_id", $program->id)->get();
        }





        return view('agent/programs', [
            'connecteduser' => $connecteduser,
            "programs" => $programs
        ]);
    }


    public function programvalidation(Request $request)
    {
        if (!Auth::guard('Agent')->user()) {
            return redirect("/login");
        }

        $connecteduser = Auth::guard('Agent')->user();

        Program::where("id", $request->id)
            ->update([
                'validation' => $request->validation,
                'agent_id' => $connecteduser->id
            ]);

        return redirect("/agent/programs");
    }


    public function invoicePage(Request $request)
    {


        if (!Auth::guard('Agent')->user()) {
            return redirect("/login");
        }

        $connecteduser = Auth::guard('Agent')->user();

        $program = Program::where("id", $request->route("id"))->first();
        $instructor = Instructor::where("id", $program->instructor_id)->first();



        // return view("agent/invoice" , [
        //     "program" => $program,
        //     "instructor" => $instructor
        // ]);

        view()->share('p', $program);
        $pdf_doc = \PDF::loadView('agent/invoice', [
            "program" => $program,
            "instructor" => $instructor
        ]);

        $name = time() . "-program" . ".pdf";

        return $pdf_doc->download($name);




    }


    public function viewProfileAgent()
    {
        if (!Auth::guard('Agent')->user()) {
            return redirect("/login");
        }



        $connecteduser = Auth::guard('Agent')->user();



        return view('Agent/profile', [

            'connecteduser' => $connecteduser,
        ]);
    }

    public function updateProfileAgent(Request $request)
    {
        $connecteduser = Auth::guard('Agent')->user();
        if($request->has("profilemanagement")){

            
                    $selectedfile = $request->file("image");
                    if ($selectedfile) {
                        $filename = time() . $selectedfile->getClientOriginalName();
                        Storage::disk('public_uploads')->put($filename, file_get_contents($selectedfile));
            
                        Agent::where('id', $connecteduser->id)
                            ->update([
                                'first_name' => $request->first_name,
                                'last_name' => $request->last_name,
                                'image' => $filename
            
                            ]);
                    } else {
                        Agent::where('id', $connecteduser->id)
                            ->update([
                                'first_name' => $request->first_name,
                                'last_name' => $request->last_name,
            
                            ]);
                    }
        }


        if($request->has("passwordmanagement")){
            if($request->newpassword == $request->newpasswordconfirmation){
                Agent::where('id', $connecteduser->id)
                    ->update([
                        'password' => bcrypt($request->newpassword)
                    ]);
            }
        }


        return redirect("/agent/profile");
    }


    public function dispaly(){
        return view('agent/dispaly');
    }





}
