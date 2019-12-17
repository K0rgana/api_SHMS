<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $table="sensores";

    protected $fillable = [
        'nome', 'tipo'
    ];

    public function sensor() {
        return $this->hasMany('App\Medicao');
    }
}
