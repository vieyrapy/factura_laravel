<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $fillable = ['monto_apertura', 'fecha'];
    public $timestamps = false;

    public static function apertura($monto){
        return Caja::create([
            'monto_apertura' => $monto
        ]);
    }
}
