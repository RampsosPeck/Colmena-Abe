<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodetalle extends Model
{

    protected $table = 'prodetalles';
    protected $fillable = ['nombre','slug','especificaion','extra','estado'];


}
