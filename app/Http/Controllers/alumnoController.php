<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\alumnos;
use Illuminate\Support\Facades\Validator;

class alumnoController extends Controller
{
    public function index(){
        $alumno = alumnos::all();
        // if ($alumno->isEmpty()) {
        //     // una opcion
        //     // return response()->json(['message' => 'No hay estudiantes registrados'], 400);
        //     $data = [
        //         'status' => 200,
        //         'title' => 'Controller error',
        //         'response' => 'No se encontraron estudiantes'
        //     ];
        //     return response()->json($data, 404);
        // }
        $data = [
            'status' => 'success',
            'title' => 'Registros',
            'responce' => $alumno
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'correo' => 'required|email|unique:alumnos',
            'telefono' => 'required|digits:10',
            'lenguaje' => 'required|in:Ingles,Español,Frances'
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 400,
                'title' => 'Error en la validación de los datos',
                'response' => $validator->errors()
            ];
            return response()->json($data, 400);
        }

        $alumno = Alumnos::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'lenguaje' => $request->lenguaje
        ]);

        if (!$alumno) {
            $data = [
                'status' => 500,
                'title' => 'Error',
                'response' => 'Error al crear el estudiante'
            ];
            return response()->json($data, 500);
        }

        $data = [
            'status' => 201,
            'title' => 'Correcto',
            'response' => $alumno
        ];

        return response()->json($data, 201);
    }

    public function show($id){
        $alumno = alumnos::find($id);
        if (!$alumno) {
            $data = [
                'status' => 404,
                'title' => 'UPS! Error',
                'reponse' => 'Estudiante no encontrado'
            ];
            return response()->json($data, 404);
        }
        $data = [
            'status' => 200,
            'title' => 'Estudiante es.',
            'response' => $alumno
        ];
        return response()->json($data, 200);
    }

    public function destroy($id){
        $alumno = alumnos::find($id);
        if (!$alumno) {
            $data = [
                'status' => 404,
                'title' => 'Estudiante 404',
                'response' => 'Estudiante no encontrado'
            ];
            return response()->json($data, 404);
        }
        $alumno->delete();
        $data = [
            'status' => 200,
            'message' => 'Estudiante',
            'response' => 'El estudiante fue borrado'
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $alumno = alumnos::find($id);
        if (!$alumno) {
            $data = [
                'status' => 404,
                'title' => 'Estudiante',
                'response' => 'Estudiante no fue encontrado'
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'correo' => 'required|email|unique:alumnos',
            'telefono' => 'required|digits:10',
            'lenguaje' => 'required|in:Ingles,Español,Frances'
        ]);
        if ($validator->fails()) {
            $data = [
                'status' => 400,
                'title' => 'Error en validación',
                'response' => $validator->errors()
            ];
            return response()->json($data, 400);
        }
        $alumno->nombre = $request->nombre;
        $alumno->correo = $request->correo;
        $alumno->telefono = $request->telefono;
        $alumno->lenguaje = $request->lenguaje;
        $alumno->save();
        $data = [
            'status' => 200,
            'title' => 'Actualizado correcto',
            'response' => $alumno
        ];
        return response()->json($data, 200);
    }
}
