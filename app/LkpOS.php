<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpOS extends Model
{
    protected $table = 'ekewangan.lkp_os';
    public $timestamps = false;

    protected $primaryKey = 'id_lkp_os';
    protected $fillable = [
        'os', 'id_lkp_oa'
    ];
}
