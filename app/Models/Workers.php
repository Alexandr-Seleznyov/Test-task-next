<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Workers extends Model
{
    protected $table = 'workers';

    public function position()
    {
        return $this->belongsTo('App\Models\Positions');
    }

    public function countChilds($id)
    {
        return $this->where('parent_id', $id)->count();
    }

    public function parent($parent_id)
    {
        if (!$parent_id) {
            return '';
        }

        $worker = $this->find($parent_id);

        if(!$worker) {
            return '';
        }

        $result = $worker['last_name'].' '.mb_substr($worker['first_name'], 0, 1).'. '.mb_substr($worker['patronymic_name'], 0, 1).'.';

        return $result;
    }

}
