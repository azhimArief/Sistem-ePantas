<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpJenisBelanja extends Model
{
    protected $table = 'ekewangan.lkp_jenis_belanja';
    public $timestamps = false;

    protected $primaryKey = 'idJenisBelanja';
    protected $fillable = [
        'jenisBelanja'
    ];
}
