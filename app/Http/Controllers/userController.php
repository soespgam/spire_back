<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class userController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'correo'=>'required|email',
            'password'=>'required',
         ]);

         $user= User::where("correo","=",$request->correo)->first();

         if(isset($user->id)){
            if(Hash::check($request->password,$user->password)){
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    'status'=>true,
                    'message'=>'usuario logueado correctamente',
                    "token"=>$token
                ],200);

            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>'contrasena incorrecta'
                ],404);
            }
         }else{
            return response()->json([
                'status'=>false,
                'message'=>'usuario no registrado'
            ],404); 
         }
       
    }

    public function register(Request $request){

        $request->validate([
           'nombre'=>'required|string|max:100',
           'correo'=>'required|string|email|unique:users',
           'telefono'=>'required',
           'password'=>'required|string|min:4',
           'rol'=>'required'
        ]);
        

        $newUser = new User;
            $newUser->nombre = $request->nombre;
            $newUser->correo=$request->correo;
            $newUser->telefono=$request->telefono;
            $newUser->password= Hash::make($request->password);
            $newUser->rol= strtoupper($request->rol);
            $newUser->save();

            return response()->json([
                'status'=>true,
                'message'=>'usuario creado exitosamente',$newUser
            ],200);

        

    }


    public function get_user_profile(){
        return response()->json([
            'status'=>true,
            'message'=>'perfil usuario',
            "data"=>auth()->user()
        ],200);

    }


    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            'status'=>true,
            'message'=>'sesion cerrada',
        ],200);

    }


    public function get_usuarios()
    {
        try {
            $usuarios= user::all();
            return response()->json($usuarios);
        } catch (\Throwable $th) {
            return response()->json([
                'status'=>false,
                'message'=>'Ocurrió un error al consultar los usuarios', $th->getMessage()
            ]);
        }
    }


    public function update(Request $request)
    {
         try {
            $editUser= user::find($request->id);
            if(isset($editUser)){
                $editUser->nombre = $request->nombre;
                $editUser->correo=$request->correo;
                $editUser->telefono=$request->telefono;
                $editUser->password= Hash::make($request->password);
                $editUser->rol= strtoupper($request->rol);
                $editUser->save();

                return response()->json([
                    'status'=>true,
                    'message'=>'el usuario se edito' ,$editUser
                ]);
            }else{
                $response = [
                    'type' => "error",
                    'content' => "el usuario consultado no existe."
                ];
                return $response;
            }
        } catch (Throwable $throwableException) {
            $response = [
                'type' => "error",
                'content' => "Ocurrió un error al actualizar el usuario."
            ];
            return $response;
        }
    }

    public function destroy_user(string $id)
    {
        $user = user::find($id);
        if(!is_null($user)){
            try {
                $user->delete();

                return response()->json([
                    'status'=>true,
                    'message'=>'el usuario fue eliminado '
                ]);

            } catch (Throwable $th) {
                return response()->json([
                    'status'=>false,
                    'message'=>"Ocurrió un error al eliminar el usuario.", $th->getMessage()
                ]);
             }
         } else {

            return response()->json([
                'status'=>false,
                'message'=>" el usuario no existe."
            ]);

        } 
        
    }


    public function get_user(string $id){
        $user_by_id= user::find($id);

        if(!is_null($user_by_id)){
            try {
                return response()->json($user_by_id);

            } catch (Throwable $th) {
                return response()->json([
                    'status'=>false,
                    'message'=>'Ocurrió un error al consultar el usuario', $th->getMessage()
                ]);
            }
        }else{
            return response()->json([
                'status'=>false,
                'message'=>"el usuario no existe."
            ]);
        }
    }




   
}
