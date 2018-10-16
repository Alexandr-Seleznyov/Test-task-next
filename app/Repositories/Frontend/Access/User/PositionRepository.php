<?php

namespace App\Repositories\Frontend\Access\User;

use App\Models\Positions;
use App\Repositories\BaseRepository;


class PositionRepository extends BaseRepository
{
    public function update($input)
    {

        $id = $input['id'];
        $position = new Positions;
        $position = $position->findOrFail($id);

        $position['title'] = $input['title'];

        return $position->save();
    }

    public function delete($id)
    {
        $position = new Positions;
        $position = $position->findOrFail($id);

        return $position->delete();
    }

    public function store($input)
    {
        $position = new Positions;
        return $position->insert(['title' => $input['title']]);
    }


}