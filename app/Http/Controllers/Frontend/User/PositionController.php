<?php

namespace App\Http\Controllers\Frontend\User;

use App\FormValidation;
use App\Http\Controllers\Controller;
use App\Models\Positions;

use App\Repositories\Frontend\Access\User\PositionRepository;
use Illuminate\Http\Request;

/**
 * Class PositionController.
 */
class PositionController extends Controller
{
    /**
     * @var PositionRepository
     */
    protected $position;

    /**
     * PositionController constructor.
     *
     * @param PositionRepository $position
     */
    public function __construct(PositionRepository $position)
    {
        $this->position = $position;
    }


    public function edit(Request $request)
    {
        $id = $request->get('id');

        $positions = new Positions;

        $position = $positions->findOrFail($id);

        return view('frontend.positions.edit',[
            'position' => $position,
        ]);
    }


    public function create()
    {
        return view('frontend.positions.create');
    }

    public function store(Request $request)
    {
        FormValidation::position($this, $request);

        $result = $this->position->store($request->all());

        $massege = $result ? 'Должность добавлена' : 'Ошибка: Не удалось добавить должность';

        $positions = new Positions;
        $positions = $positions::all();

        return view('frontend.positions.positions',[
            'positions' => $positions,
            'massege' => $massege,
            'result' => $result,
        ]);
    }


    public function update(Request $request)
    {
        FormValidation::position($this, $request);

        $result = $this->position->update($request->all());

        $positions = new Positions;
        $positions = $positions::all();

        $massege = $result ? 'Должность изменена' : 'Ошибка: Не удалось изменить должность';

        return view('frontend.positions.positions',[
            'positions' => $positions,
            'massege' => $massege,
            'result' => $result,
        ]);
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if ($this->position->delete($id))
        {
            $massage = '<div class="alert alert-success">Должность удалена</div>';
        } else {
            $massage = '<div class="alert alert-danger">Ошибка: Должность не удалена</div>';
        }

        return $massage;
    }
}
