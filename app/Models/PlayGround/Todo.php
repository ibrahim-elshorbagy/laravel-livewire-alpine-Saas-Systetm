<?php

namespace App\Models\PlayGround;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //


    protected $guarded = ['id'];


    public function images(){
        return $this->hasMany(TodoImage::class);
    }
}
