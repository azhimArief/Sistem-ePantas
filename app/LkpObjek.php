<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpObjek extends Model
{
    protected $table = 'ekewangan.lkp_objek';
    public $timestamps = false;

    protected $primaryKey = 'idObjek';
    protected $fillable = [
        'jenisPerbelanjaan', 'noVot'
    ];
}
