<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class studentController extends Controller
{
    public function index(){
        $students = Student::all();
        if($students->count() > 0){
            return response()->json([
                'status' => 200,
                'students' => $students
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'students' => $students
            ], 404);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:191'],
            'course' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191'],
            'phone' => ['required', 'digits:10']
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            if($student){
                return response()->json([
                    'status' => 200,
                    'message' => 'Student created successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong'
                ], 500);
            }
        }
    }

    public function show($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'student' => $student
            ], 404);
        }
    }

    public function update(Request $request, string $id){
        $student = Student::find($id);
        if($student){
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:191'],
                'course' => ['required', 'string', 'max:191'],
                'email' => ['required', 'email', 'max:191'],
                'phone' => ['required', 'digits:10']
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages()
                ], 422);
            }else{
                $student = Student::find($id);
                if($student){
                    $student->update([
                        'name' => $request->name,
                        'course' => $request->course,
                        'email' => $request->email,
                        'phone' => $request->phone
                    ]);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Student updated.'
                    ], 200);
                }else{
                    return response()->json([
                        'status' => 404,
                        'message' => 'Student not found.'
                    ], 404);
                }
            }
        }else{
            return response()->json([
                'status' => 404,
                'student' => $student
            ], 404);
        }
    }

    public function destroy(string $id){
        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Sudent deleted.'
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'message'=> 'Student not found.'
            ]);
        }
    }
}
