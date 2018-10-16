<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Access\User\WorkersListRepository;
use Illuminate\Http\Request;
use App\Models\Workers;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getChildsHtml(Request $request)
    {
        $id = $request->get('id');
        $workers = new Workers;

        $workers = $workers->where('parent_id', $id)->get();

        if (!count($workers)) {
            return '';
        }

        $result =
            '<div class="panel-collapse collapse in" role="tabpanel" id="'.$id.'" aria-labelledby="heading_'.$id.'" aria-expanded="true" style="">'.
                '<ul class="list-group">';

        foreach ($workers as $value)
        {
            $countChilds = $value->countChilds($value['id']);

            $result = $result.
                '<li class="list-group-item">'.
                    '<div class="panel-group" role="tablist">'.
                        '<div class="panel panel-default">'.
                            '<div class="panel-heading" role="tab" id="heading_'.$value['id'].'">'.
                                '<div class="row">';

            $col = 'col-md-offset-2';
            if($countChilds) {
                $result = $result.
                    '<a href="#'.$value['id'].'" class="btn btn-default col-md-2" role="button" data-toggle="collapse" aria-expanded="true" aria-controls="'.$value['id'].'">'.
                        '<span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span> Подчинённые <span class="badge">'.$countChilds.'</span>'.
                    '</a>';
                $col = '';
            };

            $result = $result.
                                    '<ul class="nav nav-pills task col-md-9 '.$col.'">'.
                                        '<li class="task-fio">'.$value['last_name'].'</li>'.
                                        '<li class="task-fio">'.$value['first_name'].'</li>'.
                                        '<li class="task-fio">'.$value['patronymic_name'].'</li>'.
                                        '<li class="task-position">'.$value->position['title'].'</li>'.
                                        '<li class="task-date">'.\Carbon\Carbon::parse($value['date_work'])->format('d-m-Y').'</li>'.
                                        '<li class="task-salary">'.$value['salary'].'</li>'.
                                    '</ul>'.
                                '</div>'.
                            '</div>'.

                            '<div class="wrapper-childs-'.$value['id'].'"></div>'.
                        '</div>'.
                    '</div>'.
                '</li>';
        }

        $result = $result.
                '</ul>'.
            '</div>';

        return $result;
    }

    public function editParent(Request $request)
    {
        $id = $request->get('id');
        $parent_id = $request->get('parent_id');

        $result = true;

        try {
            DB::transaction(function () use ($id, $parent_id) {

                $workersListRepository = new WorkersListRepository;
                $workers = new Workers;

                $worker = $workers->find($id); // У кого меняем начальника
                $worker_parent = $workers->find($parent_id); // На кого меняем

                $arrayEditWorkers = $workersListRepository->getArrayForUpdate($worker, $worker_parent);

                // Обновление БД по массиву
                foreach ($arrayEditWorkers as $value) {
                    $person = $workers->find($value['id']);
                    $person['parent_id'] = $value['parent_id'];
                    $person->save();
                }

            });
        } catch (\Exception $e) {
            $messError = $e->getMessage();
            $result = false;
        } catch (\Throwable $e) {
            $messError = $e->getMessage();
            $result = false;
        }


        if ($result) {
            return 'true';
        }
            return $messError;
    }


}