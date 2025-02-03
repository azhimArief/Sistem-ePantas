<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agensi extends Model
{
    protected $table = 'personel.agensi';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $primaryKey = 'id';
    protected $fillable = [
        'agensi', 'created_at', 'updated_at'
    ];
}
