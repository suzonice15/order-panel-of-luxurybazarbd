<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VCategoryRightProduct extends Model
{
    use HasFactory;
    protected  $table='VProductRightCategory';
    public  function  category(){
        return  $this->hasMany(Category::class,'category_id','parent_id');
    }}
