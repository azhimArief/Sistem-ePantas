<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerancanganPerolehan extends Model
{
    protected $table = 'ekewangan.perancangan_perolehan';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'idPerancanganPerolehan';
    protected $fillable = [
        'idPermohonan', 'kod_permohonan', 'id_status', 'pemohon', 'tindakan_oleh','tahunPPT','bahagian', 'createdAt', 'updatedAt'
    ];
}
