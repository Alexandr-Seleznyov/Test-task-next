<?php

namespace App\Http\Controllers\Frontend\User;

use App\FormValidation;
use App\Http\Controllers\Controller;

use App\Models\Positions;
use App\Models\Workers;
use App\Repositories\Frontend\Access\User\WorkersListRepository;
use Dan\UploadImage\Exceptions\UploadImageException;
use Dan\UploadImage\UploadImage;
use Illuminate\Http\Request;


/**
 * Class WorkersListController.
 */
class WorkersListController extends Controller
{
    /**
     * @var WorkersListRepository
     */
    protected $workersList;

    /**
     * WorkersListController constructor.
     *
     * @param WorkersListRepository $workersList
     */
    public function __construct(WorkersListRepository $workersList)
    {
        $this->workersList = $workersList;
    }


    public function edit(Request $request)
    {
        $id = $request->get('id');

        $workers = new Workers;
        $worker = $workers->find($id);
        $parentId = $worker['parent_id'];
        if ($parentId) {
            $parents = $workers->find($parentId);
        } else {
            $parents = null;
        }


        $positions = new Positions;
        $positions = $positions::all();

        $positionsArray = [];
        for($i = 0; $i < count($positions); $i++)
        {
            $positionsArray[$positions[$i]['id']] = $positions[$i]['title'];
        }

        if ($parents) {
            $parentsArray = [$parents['id'] => $parents['last_name'].' '.$parents['first_name'].' '.$parents['patronymic_name']];
        } else {
            $parentsArray = [];
        }

        return view('frontend.list.edit',[
            'workers' => $worker,
            'positions' => $positionsArray,
            'parents' => $parentsArray,
        ]);
    }


    public function update(Request $request)
    {

        FormValidation::workers($this, $request);

        $file = $request->file('image');
        $video = false;
        $watermark = false;
        $config = config('upload-image.image-settings');

        if ($file) {
            // Upload and save image.
            try {
                // Upload and save image.
                $uploadImage = new UploadImage($config);
                $imageName = $uploadImage->upload($file, 'task', $watermark, $video, true, true)->getImageName();
            } catch (UploadImageException $e) {
                return back()->withInput()->withErrors(['image', $e->getMessage()]);
            }
        } else {
            $imageName = null;
        }

        $result = $this->workersList->update($request->all(), $imageName);

        if ($result) {
            return redirect()->route('frontend.user.list')->withFlashSuccess('Информация о работнике изменена');
        }

        return redirect()->route('frontend.user.list')->withFlashDanger('Ошибка: Не удалось изменить информацию о работнике');

    }


    public function deleteImage(Request $request)
    {
        $id = $request->get('id');

        return $this->workersList->deleteImage($id);
    }


    public function create()
    {
        $workers = new Workers;
        $positions = new Positions;

        $positions = $positions::all();

        $positionsArray = [];
        for($i = 0; $i < count($positions); $i++)
        {
            $positionsArray[$positions[$i]['id']] = $positions[$i]['title'];
        }

        return view('frontend.list.create',[
            'workers' => $workers,
            'positions' => $positionsArray,
            'massege' => null,
        ]);
    }


    public function store(Request $request)
    {
        FormValidation::workers($this, $request);

        $file = $request->file('image');
        $video = false;
        $watermark = false;
        $config = config('upload-image.image-settings');

        if ($file) {
            // Upload and save image.
            try {
                // Upload and save image.
                $uploadImage = new UploadImage($config);
                $imageName = $uploadImage->upload($file, 'task', $watermark, $video, true, true)->getImageName();
            } catch (UploadImageException $e) {
                return back()->withInput()->withErrors(['image', $e->getMessage()]);
            }
        } else {
            $imageName = null;
        }

        $result = $this->workersList->store($request->all(), $imageName);

        if ($result) {
            return redirect()->route('frontend.user.list')->withFlashSuccess('Работник добавлен');
        }

        return redirect()->route('frontend.user.list')->withFlashDanger('Ошибка: Не удалось добавить работника');
    }



    public function destroy(Request $request)
    {
        $id = $request->get('id');
        if ($this->workersList->delete($id))
        {
            $massage = '<div class="alert alert-success">Работник удалён</div>';
        } else {
            $massage = '<div class="alert alert-danger">Ошибка: Работник не удалён</div>';
        }

        return $massage;
    }


    public function test() {
        $workers = new Workers;
        $id = '56197';// id того, у кого меняем начальника
        $newParentId = '56187'; // id нового начальника

        $worker = $workers->find($id);
        $worker_parent = $newParentId ? $workers->find($newParentId) : null; // На кого меняем


        // Распределение рабочих
        $arrayEditWorkers = $this->workersList->getArrayForUpdate($worker, $worker_parent);
        dump($arrayEditWorkers); die;
    }
}
