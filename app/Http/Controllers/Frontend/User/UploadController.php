<?php

/**
 * Controller for upload images from WYSIWYG and Delete image from WYSIWYG.
 */

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\Workers;
use App\Repositories\Frontend\Access\User\WorkersListRepository;
use Dan\UploadImage\UploadImage;
use Illuminate\Http\Request;


class UploadController extends Controller
{
    /**
     * Create preview image.
     */
    public function preview(Request $request)
    {
        $config = config('upload-image.image-settings');
        // Check exist preview request.
        if ($request->get('preview')) {
            return response()->json(['preview_width' => $config['previewWidth']]);
        }

        return response()->json(['status' => 500]);
    }


//    public function delete(Request $request)
//    {
//        $id = $request->get('id');
//
//        $workers = new Workers;
//        $workers = $workers->findOrFail($id);
//
//        $config = config('upload-image.image-settings');
//        $uploadImage = new UploadImage($config);
//        $uploadImage->delete($workers['image'], 'task');
//
////        $workers['image'] = null;
//
//        $workersListController = new WorkersListRepository;
//
//        return $workersListController->deleteImage($id);
//
////        return $workers->save();
//    }
}
