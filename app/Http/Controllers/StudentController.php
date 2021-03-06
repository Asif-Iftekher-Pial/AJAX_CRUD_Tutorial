<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        return view('crud');
    }

    public function fetchingData(){
        $allInfo=Student::orderBy('id', 'desc')->get();
       
        return response()->json([
            'allStudents'=>$allInfo
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',  //name age and number are coming from Jquery data (left side)
            'age' => 'required|numeric',
            'number' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'error'=>$validator->messages(),
            ]);
           

        } else {
            $student = new Student;
            $student->name = $request->input('name');  //input('name') > name is coming from ajax data left side  and  $student->name , name is DB column
            $student->age = $request->input('age');
            $student->number = $request->input('number');
            $student->save();
            return response()->json([
                'status'=>200,
                'message'=>'Data added successfully!'
            ]);
        }
    }

    public function edit($id){
        $get_Data = Student::find($id);
        
        if($get_Data){
            
            return response()->json([
                'status' =>200,
                'studentData'=>$get_Data
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message' =>'Student not found'
            ]);
        }

    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',  //name age and number are coming from Jquery data (left side)
            'age' => 'required|numeric',
            'number' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'error'=>$validator->messages(),
            ]);
           

        } else {
            $student =Student::find($id);
            if($student){
                $student->name = $request->input('name');  //input('name') > name is coming from ajax data left side  and  $student->name , name is DB column
                $student->age = $request->input('age');
                $student->number = $request->input('number');
                $student->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Data updated successfully!'
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message' =>'Student not found'
                ]);
            }
    

        }
    }
}
