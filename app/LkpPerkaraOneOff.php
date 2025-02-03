<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpPerkaraOneOff extends Model
{
    protected $table = 'ekewangan.lkp_jenis_perkara_oneoff';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'idJenisPerkaraOneOff';
    protected $fillable = [
        'perkaraOneOff'
    ];
}
