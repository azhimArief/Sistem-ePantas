<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpAccess extends Model
{
    protected $table = 'dd_kpn.lkp_access';
    public $timestamps = false;

    protected $primaryKey = 'id_access';
    protected $fillable = [
        'access_type'
    ];
}
