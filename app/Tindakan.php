<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $table = 'ekewangan.tindakanperkew';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'idTindakanPerkew';
    protected $fillable = [
        'idMaklumatPermohonan', 'Ulasan', 'CreatedAt', 'UpdatedAt', 'UpdatedBy', 'id_status', 'Kos'
    ];
}
