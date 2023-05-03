<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected  $table='category';
    public  function  sub(){
      return  $this->hasMany(Category::class,'parent_id','category_id');
    }
    public  function  child(){
        return  $this->hasMany(Category::class,'parent_id','category_id');
    }
}
