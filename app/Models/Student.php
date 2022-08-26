<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
   
    protected $table="students";
    protected $primarKey="id";
    protected $fillable=['name','email','mobile','address'];
    

   
}
