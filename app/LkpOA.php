<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpOA extends Model
{
    protected $table = 'ekewangan.lkp_oa';
    public $timestamps = false;

    protected $primaryKey = 'id_lkp_oa';
    protected $fillable = [
        'oa'
    ];
}
