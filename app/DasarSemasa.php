<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DasarSemasa extends Model
{
    protected $table = 'ekewangan.dasar_semasa';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id';
    protected $fillable = [
        'dasarSemasa', 'idMaklumatPermohonan'
    ];
}
