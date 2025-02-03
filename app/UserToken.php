<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $table = 'ekewangan.users_token';
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	// protected $primaryKey = 'idTindakanPerkew+';
    protected $fillable = [
        'email', 'token', 'created_at'
    ];
}
