<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PPemohonPeruntukan extends Model
{
    protected $table = 'ekewangan.pemohon_peruntukan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'idPemohonPeruntukan';
    // public $incrementing = false;
    
    protected $fillable = [
        'namaPemohon', 'namaBahagian', 'kertasCadangan', 'minitCadangan', 'gredPemohon', 'jawatanPemohon'
    ];
}
