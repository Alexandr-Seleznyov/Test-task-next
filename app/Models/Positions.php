<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $table = 'positions';

    public function worker()
    {
        return $this->hasOne('App\Models\Workers');
    }
}
