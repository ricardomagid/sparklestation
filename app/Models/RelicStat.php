<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelicStat extends Model
{
    protected $table = 'relic_stats';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'main_possible',
        'sub_possible',
    ];  
}