<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LatarBelakang extends Model
{
    protected $table = 'ekewangan.latar_belakang';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id';
    protected $fillable = [
        'latarBelakang', 'idMaklumatPermohonan'
    ];
}
