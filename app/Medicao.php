<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicao extends Model
{
    protected $table="medicoes";
    
    protected $fillable = [
        'valor', 'data_horario','sensor_id'
    ];

    function sensor() {
        return $this->belongsTo('App\Sensor');
    }
}
