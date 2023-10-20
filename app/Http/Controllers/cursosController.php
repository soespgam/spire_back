<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\curso;

class cursosController extends Controller
{
    public function create(Request $request){

        $request->validate([
            'nombre_curso'=>'required|string|max:100',
            'intensidad_horaria'=>'required',
        ]);

        $newCurso = new curso;
        $newCurso->nombre_curso = $request->nombre_curso;
        $newCurso->intensidad_horaria=$request->intensidad_horaria;
        $newCurso->save();
            return response()->json([
                'status'=>true,
                'message'=>'curso creado exitosamente',$newCurso
            ]);
    }


    public function get_cursos(){
        try {
            $usuarios= curso::all();
            return response()->json($usuarios);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>'Ocurrió un error al consultar los cursos', $th->getMessage()
            ]);
        }
    }

    public function get_curso(string $id){
        $curso_by_id= curso::find($id);

        if(!is_null($curso_by_id)){
            try {
                return response()->json($curso_by_id);

            } catch (Throwable $th) {
                return response()->json([
                    'status'=>false,
                    'message'=>'Ocurrió un error al consultar el curso', $th->getMessage()
                ]);
            }
        }else{
            return response()->json([
                'status'=>false,
                'message'=>"el curso no existe."
            ]);
        }
    }

    public function update(Request $request)
    {
         try {
            $editCurso = curso::find($request->id);
            if(isset($editCurso)){
                $editCurso->nombre_curso= $request->nombre_curso;
                $editCurso->intensidad_horaria= $request->intensidad_horaria;
                $editCurso->save();

                return response()->json([
                    'status'=>true,
                    'message'=>'el curso se edito' ,$editCurso
                ]);
            }else{
                $response = [
                    'type' => "error",
                    'content' => "el curso consultado no existe."
                ];
                return $response;
            }
        } catch (Throwable $throwableException) {
            $response = [
                'type' => "error",
                'content' => "Ocurrió un error al actualizar el curso."
            ];
            return $response;
        }
    }


    public function destroy(string $id)
    {
        $curso = curso::find($id);
        if(!is_null($curso)){
            try {
                $curso->delete();

                return response()->json([
                    'status'=>true,
                    'message'=>'curso eliminado '
                ]);
                return response()->json('');

            } catch (Throwable $throwableException) {
                $response = [
                    'type' => "error",
                    'content' => "Ocurrió un error al eliminar el curso.", $th->getMessage()
                ];
            }
         } else {

            return response()->json([
                'status'=>false,
                'message'=>"el curso no existe."
            ]);

        } 
        
    } 


}
