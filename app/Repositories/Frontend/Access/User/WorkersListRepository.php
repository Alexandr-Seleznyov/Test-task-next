<?php

namespace App\Repositories\Frontend\Access\User;

use App\Models\Workers;
use App\Repositories\BaseRepository;
use Dan\UploadImage\UploadImage;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;


class WorkersListRepository extends BaseRepository
{
    protected $isDownParent = false; // Новый начальник ниже по иерархии

    public function update($input, $imageName)
    {
        $id = $input['id'];

        $result = true;
        try {
            DB::transaction(function () use ($id, $imageName, $input) {

                $workers = new Workers;
                $newParentId = array_key_exists('parent_id', $input) ? $input['parent_id'] : null; // id нового начальника

                $worker = $workers->find($id); // У кого меняем начальника
                $worker_parent = $newParentId ? $workers->find($newParentId) : null; // На кого меняем


                if (!is_null($worker_parent)) {
                    // Распределение рабочих
                    $arrayEditWorkers = $this->getArrayForUpdate($worker, $worker_parent);

                    // Обновление БД по массиву
                    foreach ($arrayEditWorkers as $value) {
                        $person = $workers->find($value['id']);
                        $person['parent_id'] = $value['parent_id'];
                        $person->save();
                    }
                } else {
                    $worker['parent_id'] = $newParentId;
                }


                if ($imageName) {
                    $config = config('upload-image.image-settings');
                    $uploadImage = new UploadImage($config);
                    $uploadImage->delete($worker['image'], 'task');

                } else {
                    $imageName = $worker['image'];
                }

                $worker['image'] = $imageName;
                $worker['last_name'] = $input['last_name'];
                $worker['first_name'] = $input['first_name'];
                $worker['patronymic_name'] = $input['patronymic_name'];
                $worker['position_id'] = array_key_exists('position_id', $input) ? $input['position_id'] : null;
                $worker['date_work'] = $input['date_work'];
                $worker['salary'] = $input['salary'];
//                $worker['parent_id'] = $newParentId;


                $worker->save();


            });
        } catch (\Exception $e) {
            $result = false;
        } catch (\Throwable $e) {
            $result = false;
        }

        return $result;
    }

    public function deleteImage($id)
    {
        $workers = new Workers;
        $workers = $workers->findOrFail($id);

        $config = config('upload-image.image-settings');
        $uploadImage = new UploadImage($config);
        $uploadImage->delete($workers['image'], 'task');

        $workers['image'] = null;
        return $workers->save();
    }

    public function delete($id)
    {
        $result = true;
        try {
            DB::transaction(function () use ($id) {

                $workers = new Workers;
                $worker = $workers->find($id);
                $worker->delete();

                $workers->where('parent_id', $id)->update(['parent_id' => null]);

            });
        } catch (\Exception $e) {
            $result = false;
        } catch (\Throwable $e) {
            $result = false;
        }

        return $result;
    }

    public function store($input, $imageName)
    {
        $worker = new Workers;

        $worker['image'] = $imageName;
        $worker['last_name'] = $input['last_name'];
        $worker['first_name'] = $input['first_name'];
        $worker['patronymic_name'] = $input['patronymic_name'];
        $worker['position_id'] = array_key_exists('position_id', $input) ? $input['position_id'] : null;
        $worker['date_work'] = $input['date_work'];
        $worker['salary'] = $input['salary'];
        $worker['parent_id'] = array_key_exists('parent_id', $input) ? $input['parent_id'] : null;

        return $worker->save();
    }



    public function getArrayForUpdate($editWorker, $parentWorker)
    {
        // Работа с массивом:
        // 1. Новый начальник parentWorker НИЖЕ по иерархии ???
        //      1.1 ДА !!!
        //          2.1.1 Изменяем начальника parentWorker на бывшего начальника editWorker
        //          2.1.2 Изменяем начальника editWorker на parentWorker
        //          2.1.3 Изменяем начальника у бывших подчинённых editWorker на parentWorker
        //          2.1.4 Изменяем начальника у бывших подчинённых parentWorker на editWorker
        //      1.2 НЕТ !!!
        //          2.1.1 Изменяем начальника editWorker на parentWorker


        $workers = new Workers;
        $this->spotChild($workers, $editWorker['id'], $parentWorker['id']);

        if ($this->isDownParent) {
            // Новый начальник НИЖЕ
            $arrayEditWorkers = $this->getArrayEditWorkers($parentWorker, $editWorker);
        } else {
            // Новый начальник ВЫШЕ
            $arrayEditWorkers = [];
            array_push($arrayEditWorkers, [
                'id' => $editWorker['id'],
                'parent_id' => $parentWorker['id'],
            ]);
        }

        return $arrayEditWorkers;
    }

    protected function spotChild(Workers $workers, $id, $newParentId)
    {
        $query = $workers->where('parent_id', '=', $id);
        $countChilds = $query->count();

        if ($countChilds == 0 || $this->isDownParent) return;

        $childs = $query->get();

        foreach ($childs as $value) {
            if ($value['id'] == $newParentId) {
                $this->isDownParent = true;
                return;
            }
            $this->spotChild($workers, $value['id'], $newParentId);
        }
    }


    protected function getArrayEditWorkers($parentWorker, $editWorker)
    {
        $arrayEditWorkers = [];

        $arrayEditWorkers = $this->addArrayChilds($arrayEditWorkers, $editWorker['id'], $parentWorker['id']);
        $arrayEditWorkers = $this->addArrayChilds($arrayEditWorkers, $parentWorker['id'], $editWorker['id']);

        array_push($arrayEditWorkers, [
            'id' => $parentWorker['id'],
            'parent_id' => $editWorker['parent_id'],
        ], [
            'id' => $editWorker['id'],
            'parent_id' => $parentWorker['id'],
        ]);


        return $arrayEditWorkers;
    }


    protected function addArrayChilds($arrayEditWorkers, $parentId, $newParentId)
    {
        $workers = new Workers;
        $childsOfParent = $workers->where('parent_id', '=', $parentId)->get();

        foreach ($childsOfParent as $value){
            array_push($arrayEditWorkers,[
                'id' => $value['id'],
                'parent_id' => $newParentId,
            ]);
        }

        return $arrayEditWorkers;
    }


}