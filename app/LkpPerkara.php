<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LkpPerkara extends Model
{
    protected $table = 'ekewangan.lkp_perkara';
    public $timestamps = false;

    protected $primaryKey = 'id_lkp_perkara';
    protected $fillable = [
        'perkara', 'id_lkp_os'
    ];
}
