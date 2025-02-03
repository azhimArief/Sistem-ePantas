<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JustifikasiPermohonan extends Model
{
    protected $table = 'ekewangan.justifikasi_permohonan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id';
    protected $fillable = [
        'justifikasiPermohonan', 'idMaklumatPermohonan'
    ];
}
