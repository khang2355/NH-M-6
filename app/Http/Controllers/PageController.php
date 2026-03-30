<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Hiển thị trang giới thiệu.
     *
     * @return \Illuminate\View\View
     */
    public function gioi_thieu()
    {
        return view('store.gioi_thieu');
    }
}