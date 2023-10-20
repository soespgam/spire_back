<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assignation extends Model
{
    use HasFactory;
    protected $table='assignments';
    protected $primaryKey ='id';


    public function scopeUser($query ,$user_id){
        if($user_id){
            return $query->where('user_id','LIKE',"%$user_id%");
        }
    }

    public function scopeCurso($query ,$curso_id){
        if($curso_id){
            return $query->where('curso_id','LIKE',"%$curso_id%");
        }
    }
}
