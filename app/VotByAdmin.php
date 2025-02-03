<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VotByAdmin extends Model
{
    protected $table = 'ekewangan.votbyadmin';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'idVotByAdmin';
    protected $fillable = [
        'objekAm', 'objekSebagai', 'idMaklumatPermohonan', 'kos', 'id_Status'
    ];
}
