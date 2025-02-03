<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengesah extends Model
{
    protected $table = 'ekewangan.pengesah';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'idPengesah';
    protected $fillable = [
        'idMaklumatPermohonan', 'namaPengesah', 'jawatanPengesah', 'bahagianPengesah', 'agensiPengesah'
    ];
}
