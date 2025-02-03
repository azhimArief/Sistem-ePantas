<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpJenisPeruntukan extends Model
{
    protected $table = 'ekewangan.lookup_jenis_peruntukan';
    public $timestamps = false;

    protected $primaryKey = 'id_jenis_peruntukan';
    protected $fillable = [
        'jenis_perbelanjaan'
    ];
}
