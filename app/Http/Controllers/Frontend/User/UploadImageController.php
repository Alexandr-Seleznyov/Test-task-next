<?php

/**
 * Controller for upload images from WYSIWYG and Delete image from WYSIWYG.
 */

//namespace Dan\UploadImage\Controllers;
namespace App\Http\Controllers\Frontend\User;

//use Dan\UploadImage\UploadImageFacade as UploadImage;
// //use Illuminate\Routing\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Dan\UploadImage\Exceptions\UploadImageException;

class UploadImageController extends Controller
{
    /**
     * Folder name for upload images from WYSIWYG editor.
     */
    protected $editor_folder;

    /**
     * Width for preview image.
     */
    protected $previewWidth;

    /**
     * Watermark image status for WYSIWYG editor (default disable).
     */
    protected $watermarkEditorStatus;

    // Get settings from config file.
    public function __construct()
    {
//        $config = \Config::get('upload-image.image-settings');
        $config = [
            // Use thumbnails or not.
            'thumbnail_status' => false,

            // Base store for images.
            'baseStore' => '/images/uploads/',

            // Original folder for images.
            'original' => 'original/',

            // Original image will be resizing to 800px.
            'originalResize' => 800,

            // Image quality for save image in percent.
            'quality' => 80,

            // Array with width thumbnails for images.
            'thumbnails' => ['200', '400'],

            // Watermark image status for WYSIWYG editor (default disable).
            'watermarkEditorStatus' => false,

            // Watermark image.
            'watermark_path' => '/images/design/watermark.png',

            // Watermark image.
            'watermark_video_path' => '/images/design/logo_player.png',

            // Watermark text.
            'watermark_text' => 'CleverMan.org',

            // Minimal width for uploading image.
            'min_width' => 500,

            // Width for preview image.
            'previewWidth' => 200,

            // Folder name for upload images from WYSIWYG editor.
            'editor_folder' => 'editor_post',
        ];

        $this->editor_folder = $config['editor_folder'];
        $this->previewWidth = $config['previewWidth'];
        $this->watermarkEditorStatus = $config['watermarkEditorStatus'];
    }


//    /**
//     * Upload file to server.
//     */
//    public function upload(Request $request)
//    {
//        // Check exist file (files or link).
//        if (!$request->file('files') && !$request->get('image')) {
//            return response()->json(['status' => 500]);
//        }
//
//        // If array with files.
//        if ($request->file('files')) {
//            $files = $request->file('files');
//        }
//
//        // If link to file.
//        if ($request->get('image')) {
//            // Get file from url.
//            $files[] = $request->get('image');
//        }
//
//        // If file is array with many files.
//        if (!is_array($files)) {
//            return response()->json(['status' => 500]);
//        }
//
//        $images = [];
//        $errors = [];
//
//        // Get every file and upload it.
//        foreach ($files as $file) {
//            try {
//                // Upload and save image.
//                $savedImage = UploadImage::upload($file, $this->editor_folder, $this->watermarkEditorStatus);
//
//                // Get only image url.
//                $images[] = $savedImage->getImageUrl();
//            } catch (UploadImageException $e) {
//                $errors[] = $e->getMessage();
//            }
//        }
//
//        return response()->json(['url' => $images, 'error' => $errors]);
//    }



//    /**
//     * Delete file from server.
//     */
//    public function delete(Request $request)
//    {
//        // Check exist file.
//        if ($request->get('file')) {
//            $image_name = explode('/', $request->get('file'));
//
//            // Delete image from server.
//            UploadImage::delete(last($image_name), $this->editor_folder);
//        }
//
//        return response()->json(['status' => 200]);
//    }



    /**
     * Create preview image.
     */
    public function preview(Request $request)
    {
        return '200';
//        return $this->previewWidth;
//
//        // Check exist preview request.
//        if ($request->get('preview')) {
//            return response()->json(['preview_width' => $this->previewWidth]);
//        }
//
//        return response()->json(['status' => 500]);
    }
}
