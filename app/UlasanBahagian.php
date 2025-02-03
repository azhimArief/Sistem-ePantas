<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UlasanBahagian extends Model
{
    protected $table = 'ekewangan.ulasan_bahagian';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id';
    protected $fillable = [
        'ulasanBahagian', 'idMaklumatPermohonan'
    ];
}
