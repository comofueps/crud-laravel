<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class StudentController extends Controller
{
    //
    function index()
    {
        $students = Student::all();

        if ($students->isEmpty()) {
            $data = [
                'message' => 'No se encontraron estudiantes',
                'status' => 200
            ];
            return response()->json($data, 404);
        }
        return response()->json($students, 200);
    }

    public function store(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|size:10',
            'age' => 'required|integer|between:0,74',
            'email' => 'required|email|unique:student',
            'language' => 'required|in:español,ingles,frances'
        ]);

        if ($validador->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'error' => $validador->errors(),
                'status' => '400'
            ];
            return response()->json($data, 400);
        }

        $student = Student::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'age' => $request->age,
            'email' => $request->email,
            'language' => $request->language
        ]);

        $data = [
            'student' => $student,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        };

        $data = [
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        };

        $student->delete();

        $data = [
            'message' => 'Estudiante eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {

        $student = Student::find($id);

        if (!$student) {
            $data = [
                'message' => 'Estudiante no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }


        $validador = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|size:10',
            'age' => 'required|integer|between:0,74',
            'email' => 'required|email|unique:student',
            'language' => 'required|in:español,ingles,frances'
        ]);

        if ($validador->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'error' => $validador->errors(),
                'status' => '400'
            ];
            return response()->json($data, 400);
        }


        $student->name = $request->name;
        $student->lastname = $request->lastname;
        $student->age = $request->age;
        $student->email = $request->email;
        $student->language = $request->language;

        $data = [
            'message' => 'Estudiante actualizado',
            'student' => $student,
            'status' => 200
        ];


        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id){
        $student = Student::find($id);

        if(!$student){
            $data=[
                'message','Estudiante no encontrado',
                'status',400
            ];

            return response()->json($data,400);

        }

        $validador = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'lastname' => 'string|max:255',
            'phone' => 'string|size:10',
            'age' => 'integer|between:0,74',
            'email' => 'email|unique:student',
            'language' => 'in:español,ingles,frances'
        ]);

        if ($validador->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'error' => $validador->errors(),
                'status' => '400'
            ];
            return response()->json($data, 400);
        }

        if($request->has('name')){
            $student->name = $request->name;
        }

        if($request->has('lastname')){
            $student->lastname = $request-> lastname;
        }

        if($request->has('age')){
            $student->age = $request->age;
        }

        if($request->has('phone')){
            $student->phone = $request->phone;
        }

        if($request->has('email')){
            $student->email = $request->email;
        }

        if($request->has('language')){
            $student->language = $request->language;
        }

        $student->save();

        $data=[
            'message'=>'Estudiante actualizado',
            'student'=>$student,
            'status'=>200
        ];
        
        return response()->json($data,200);

    }
}
