<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramDirancang extends Model
{
    protected $table = 'ekewangan.program_dirancang';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'idProgramDirancang';
    protected $fillable = [
        'idPermohonan','tujuanProgram', 'kosProgram', 'tkhMula', 'tkhTamat', 'pembekal', 'idJenisBelanja', 'kosSetahun', 'idJenisPerkaraOneOff',
        'quantityOneOff','justifikasi', 'createdAt', 'updatedAt'
    ];
}
