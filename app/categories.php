<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    public $table = 'categories';
    public $primaryKey ='category';
    public $timestamps = false;


    protected $fillable=['category','user'];
}
