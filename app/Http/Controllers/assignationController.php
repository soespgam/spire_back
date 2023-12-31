<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\curso;
use App\Models\assignation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class assignationController extends Controller
{
    public function get_alumnos(){
        $alumnos =DB::table('users')
        ->select('users.id','users.nombre')
        ->where('users.rol', '=', 'ALUMNO')
        ->get();
        return response()->json($alumnos);
    }

    public function create(Request $request){

        $curso_by_id= curso::find($request->curso_id);
        $user_by_id= User::find($request->user_id);

        if(!is_null($curso_by_id) ){
            if(!is_null($user_by_id)){

                $newAssignation = new assignation;
                $newAssignation->curso_id = $request->curso_id;
                $newAssignation->user_id=$request->user_id;
                $newAssignation->save();
                    return response()->json($newAssignation);   
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'el usuario seleccionado para la asignacion no existe'
                ]);
            }
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'el curso seleccionado para la asignacion no existe',
            ]);

        }
        
    }

    public function get_assignments(){
        try {
            $asignaciones = DB::table('assignments')
            ->join('users', 'assignments.user_id', '=', 'users.id')
            ->join('cursos', 'assignments.curso_id', '=', 'cursos.id')
            ->select('assignments.id','assignments.curso_id','assignments.user_id','users.nombre','cursos.nombre_curso','cursos.intensidad_horaria')
            ->get();
        return response()->json($asignaciones);
        } catch (\Throwable $th) {
            
            return response()->json([
                'status'=>false,
                'message'=>'Ocurrió un error al consultar las asignaciones', $th->getMessage()
            ]);
        }
    }

    

    public function get_assignation(string $id){
        $assignation_by_id = DB::table('assignments')
            ->join('users', 'assignments.user_id', '=', 'users.id')
            ->join('cursos', 'assignments.curso_id', '=', 'cursos.id')
            ->select('assignments.id','assignments.curso_id','assignments.user_id','users.nombre','cursos.nombre_curso','cursos.intensidad_horaria')
            ->where('assignments.id', '=', $id)
            ->get();

        if(!is_null($assignation_by_id)){
            try {
                return response()->json($assignation_by_id);

            } catch (Throwable $th) {
                return response()->json([
                    'status'=>false,
                    'message'=>'Ocurrió un error al consultar la asignacion', $th->getMessage()
                ]);
            }
        }else{
            return response()->json([
                'status'=>false,
                'message'=>"la asignacion no existe."
            ]);
        }
    }

    public function update_assignation(Request $request)
    {
        $curso_id= curso::find($request->curso_id);
        $user_id= User::find($request->user_id);

         try {
            $editAssignation = assignation::find($request->id);
            if(isset($editAssignation)){
                if(!is_null($curso_id) ){
                    if(!is_null($user_id)){
        
                        $editAssignation->curso_id = $request->curso_id;
                        $editAssignation->user_id=$request->user_id;
                        $editAssignation->save();

                        return response()->json([
                            'status'=>true,
                            'message'=>'la asignacion se edito' ,$editAssignation
                ]);   
                    }else{
                        return response()->json([
                            'status'=>false,
                            'message'=>'el usuario seleccionado para la asignacion no existe'
                        ]);
                    }
                }else{
                    return response()->json([
                        'status'=>false,
                        'message'=>'el curso seleccionado para la asignacion no existe',
                    ]);
        
                }
            }else{
                $response = [
                    'type' => "error",
                    'content' => "la asignacion consultada no existe."
                ];
                return $response;
            }
        } catch (Throwable $throwableException) {
            $response = [
                'type' => "error",
                'content' => "Ocurrió un error al actualizar la asignacion."
            ];
            return $response;
        }
    }

    public function destroy_assignation(string $id)
    {
        $assignation = assignation::find($id);
        if(!is_null($assignation)){
            try {
                $assignation->delete();

                return response()->json([
                    'status'=>true,
                    'message'=>'la asignacion fue eliminada '
                ]);

            } catch (Throwable $th) {
                return response()->json([
                    'status'=>false,
                    'message'=>"Ocurrió un error al eliminar la asignacion.", $th->getMessage()
                ]);
             }
         } else {

            return response()->json([
                'status'=>false,
                'message'=>"la asignacion no existe."
            ]);

        } 
        
    }

    public function assignation_by_user($id){
        $assignation = DB::table('assignments')
            ->join('users', 'assignments.user_id', '=', 'users.id')
            ->join('cursos', 'assignments.curso_id', '=', 'cursos.id')
            ->select('assignments.id','assignments.curso_id','assignments.user_id','users.nombre','cursos.nombre_curso','cursos.intensidad_horaria')
            ->where('users.id', '=', $id)
            ->get();
        return response()->json($assignation);
    }

}

