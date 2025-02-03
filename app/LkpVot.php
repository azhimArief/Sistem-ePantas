<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpVot extends Model
{
    protected $table = 'ekewangan.lkp_vot';
    public $timestamps = false;

    protected $primaryKey = 'idVot';
    protected $fillable = [
        'noVot', 'namaVot'
    ];
}
