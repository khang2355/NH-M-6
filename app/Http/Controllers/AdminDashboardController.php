<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'san_pham' => Product::count(),
            'danh_muc' => Category::count(),
            'bien_the' => ProductVariant::count(),
            'banner' => Banner::count(),
            'tai_khoan' => User::count(),
            'lien_he' => Contact::count(),
        ];

        $san_pham_moi = Product::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'san_pham_moi'));
    }
}
