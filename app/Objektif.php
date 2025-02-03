<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objektif extends Model
{
    protected $table = 'ekewangan.objektif';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'idObjektif';
    protected $fillable = [
        'idMaklumatPermohonan', 'obj1', 'obj2', 'obj3', 'obj4', 'obj5'
    ];
}
