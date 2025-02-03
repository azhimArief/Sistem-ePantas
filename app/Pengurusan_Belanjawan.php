<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengurusan_Belanjawan extends Model
{
    protected $table = 'ekewangan.pengurusan_belanjawan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'idPengurusanBelanjawan';
    protected $fillable = [
        'id_vot', 'PeruntukanDiluluskan', 'PeruntukanTambahKurang', 'PeruntukanPinda', 'JumTangungan', 'JumBelanja', 'BakiPeruntukan', 'PeratusBaki', 'idBilLaporan', 
        'created_at', 'created_by'
    ];
}
