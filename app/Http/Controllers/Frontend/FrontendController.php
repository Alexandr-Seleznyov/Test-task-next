<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Workers;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $workers = new Workers;

        // Передаём только начальников 1-го уровня, остальное ajax
        $workers = $workers
            ->where('parent_id', null)
            ->orderBy('last_name')
            ->get();

        return view('frontend.index',[
            'workers' => $workers,
        ]);
    }

}
