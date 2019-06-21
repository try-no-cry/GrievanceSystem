<?php

namespace App;
use App\Grievance;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    public $table = 'notifications';
    protected $guarded=[];
    public $primaryKey ='id';
    public $timestamp =true;
    public $incrementing =true;


    public function grievance(){
        return $this->belongsTo(Grievance::class);
    }
}
