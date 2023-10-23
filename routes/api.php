<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\cursosController;
use App\Http\Controllers\assignationController;





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 
//CRUD usuario
Route::post('/login',[userController::class,'login']);
Route::post('/register',[userController::class,'register']);

Route::group(['middleware'=>["auth:sanctum"]],function(){
    Route::get('/profile_user',[userController::class,'get_user_profile']);
    Route::get('/logout',[userController::class,'logout']);
});

Route::get('/usuarios',[userController::class,'get_usuarios']);
Route::post('/update_usuario',[userController::class,'update']);
Route::delete('user/{id}',[userController::class,'destroy_user']);
Route::get('user/{id}',[userController::class,'get_user']);


//CRUD cursos
Route::post('/create_curso',[cursosController::class,'create']);
Route::get('/cursos',[cursosController::class,'get_cursos']);
Route::get('curso/{id}',[cursosController::class,'get_curso']);
Route::post('/update',[cursosController::class,'update']);
Route::delete('curso/{id}',[cursosController::class,'destroy']);

//CRUD asignaciones
Route::post('/create',[assignationController::class,'create']);
Route::get('/assignments',[assignationController::class,'get_assignments']);
Route::post('/update_assignation',[assignationController::class,'update_assignation']);
Route::delete('assignation_user/{id}',[assignationController::class,'destroy_assignation']);
Route::get('alumnos',[assignationController::class,'get_alumnos']);
Route::get('assignation/{id}',[assignationController::class,'get_assignation']);
Route::get('assignation_by_user/{id}',[assignationController::class,'assignation_by_user']);


