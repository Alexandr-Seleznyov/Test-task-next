<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Positions;
use App\Models\Workers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class TaskController.
 */
class TaskController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function workersList()
    {
//        $workers = new Workers;
//        $workers = $workers->orderBy('id', 'desc')->take(10)->get();

        return view('frontend.list.list',[
//            'workers' => $workers,
            'workers' => [],
            'massege' => null
        ]);
    }

    public function workersListAjax(Request $request)
    {
        $options = json_decode($request->get('options'), true);
        $rows = (int) $request->get('rows');
        $countAddRows = (int) $request->get('countAddRows');
        $isPositions = false;
        $isParent = false;

        $workers = new Workers;
        $query = $workers;

        foreach ($options as $key => $value){
            $fieldName = substr($key, strpos($key, '_') + 1);
            $prefix = substr($key, 0, strpos($key, '_') + 1);

            if ($prefix == 'sort_' && !is_null($value)) {
                $sort = $value == 0 ? 'asc' : 'desc';
                if ($fieldName == 'position') {
                    $query = $query->join('positions', 'workers.position_id', '=', 'positions.id')
                        ->orderBy('positions.title', $sort);
                    $isPositions = true;
                } elseif($fieldName == 'parent') {

                    $query = $query->join(DB::raw('(select id, concat(last_name," ",first_name," ",patronymic_name) as fio from workers) as parent'), 'workers.parent_id', '=', 'parent.id')
                        ->orderBy('parent.fio', $sort);

                    $isParent = true;

                } else {
                    $query = $query->orderBy($fieldName, $sort);
                }
            }


            if ($prefix == 'search_' && $value != '') {

                if ($fieldName == 'position') {
                    if (!$isPositions) {
                        $query = $query->join('positions', 'workers.position_id', '=', 'positions.id');
                    }
                    $query = $query->where('positions.title',  'like', '%'.$value.'%');

                } elseif($fieldName == 'parent') {
                    if (!$isParent) {
                        $query = $query->join(DB::raw('(select id, concat(last_name," ",first_name," ",patronymic_name) as fio from workers) as parent'), 'workers.parent_id', '=', 'parent.id')
                            ->orderBy('parent.fio', $sort);
                    }
                    $query = $query->where('parent.fio',  'like', '%'.$value.'%');

                } else {
                    $query = $query->where($fieldName,  'like', '%'.$value.'%');
                }
            }

        };

        $countRows = $query->count();

        $query = $query
            ->skip($rows)
            ->take($countAddRows)->get();

        $result = '';
                foreach($query as $value)
                {
                    $img = $value['image'] ? 'images/uploads/tasks/w50/'.$value['image'] : 'img/default.png';
                    $result = $result .
                        '<tr>'.
                            '<td>'.
                                '<img src="' . asset($img) . '" class="img-rounded img-rounded" style="width: 50px">'.
                            '</td>'.
                            '<td>'. $value['last_name'] .'</td>'.
                            '<td>'. $value['first_name'] .'</td>'.
                            '<td>'. $value['patronymic_name'] .'</td>'.
                            '<td>'. $value->position['title'] .'</td>'.
                            '<td>'. \Carbon\Carbon::parse($value['date_work'])->format('d-m-Y') .'</td>'.
                            '<td>'. $value['salary'] .'</td>'.
                            '<td>'. $value->parent($value['parent_id']) .'</td>'.
                            '<td>'.
                                '<a href="'. route('frontend.user.list.edit', array('id' => $value['id'])) .'" class="btn btn-xs btn-primary">'.
                                    '<i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить"></i>'.
                                '</a>'.
                                '<a href="javascript:void(0);" class="btn btn-xs btn-danger" data-id="'. $value['id'] .'" id="delete-'. $value['id'] .'">'.
                                    '<i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить"></i>'.
                                '</a>'.
                            '</td>'.
                        '</tr>';
                }

        return json_encode(['countRows' => $countRows, 'htmlResult' => $result]);
    }


    /**
     * @return \Illuminate\View\View
     */
    public function positions()
    {
        $positions = new Positions;

        $positions = $positions::all();

        return view('frontend.positions.positions',[
            'positions' => $positions,
            'massege' => null
        ]);
    }

    public function parentSearch(Request $request)
    {
        $text = $request->get('text');
        $id = $request->get('id');
        $parentId = null;

        $workers = new Workers;
        if ($id) {

            $search = $workers
                ->where('id', '<>', $id)
                ->where(function ($query) use($text) {
                    $query->where('last_name', 'LIKE', '%'.$text.'%')
                        ->orWhere('first_name', 'LIKE', '%'.$text.'%')
                        ->orWhere('patronymic_name', 'LIKE', '%'.$text.'%');
                });

        } else {
            $search = $workers->where('last_name', 'LIKE', '%'.$text.'%')
                ->orWhere('first_name', 'LIKE', '%'.$text.'%')
                ->orWhere('patronymic_name', 'LIKE', '%'.$text.'%');
        }


        if ($text != '') {
            $count = $search->count();
            $view = $count < 10 ? $count : 10;
            $array = $search->take($view)->get();
        } else {
            $count = '';
            $view = '';
            if ($id) {
                $parentId = $workers->select(['parent_id'])->find($id);
                $array = $workers->findOrFail($parentId);
            } else {
                $array = [];
            }
        }

        $resultUp =
            '<i>Найдено всего: '.$count.'</i><br>'.
            '<i>Показано в списке: '.$view.'</i>';

        $resultDown = '<select id="parent_id" name="parent_id" class="form-control">';

            foreach ($array as $value) {
                $resultDown = $resultDown . '<option value="'.$value['id'].'">'.$value['last_name'].' '.$value['first_name'].' '.$value['patronymic_name'].'</option>';
            }

        $resultDown = $resultDown . '</select>';

        return json_encode(['resultUp' => $resultUp, 'resultDown' => $resultDown]);
    }

}
