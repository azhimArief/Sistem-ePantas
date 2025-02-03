<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaklumatPermohonan extends Model
{
    protected $table = 'ekewangan.maklumat_permohonan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'idMaklumatPermohonan';
    protected $fillable = [
        'idPemohonPeruntukan', 'id_bahagian', 'id_agensi', 'kod_permohonan', 'rujukan_fail' ,'namaProgram', 'tujuanProgram', 'latarBelakang', 'dasarSemasa', 'justifikasiPermohonan', 'ulasanBahagian',
         'id_jenis_peruntukan', 'id_jenis_perbelanjaan', 'tkhCadangMula', 'tkhCadangAkhir', 'id_status', 'kosMohon', 'kosSebenar',
        'syor', 'doc_Sokongan', 'perancangan', 'createdAt', 'updatedAt'
    ];

    // MaklumatPermohonan model
    // public function objektif() {
    //     return $this->hasMany(Objektif::class, 'idMaklumatPermohonan');
    // }
    // public function tindakans() {
    //     return $this->hasMany(Tindakan::class, 'idMaklumatPermohonan');
    // }
    // public function votByAdmins() {
    //     return $this->hasMany(VotByAdmin::class, 'idMaklumatPermohonan');
    // }
}
