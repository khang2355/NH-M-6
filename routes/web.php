<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\LoaiBienTheController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\BienTheSanPhamController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\LienHeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminDashboardController;

// Auth
Route::get('/dang_nhap', [AuthController::class, 'hien_thi_dang_nhap'])->name('dang_nhap');
Route::get('/login', [AuthController::class, 'hien_thi_dang_nhap'])->name('login'); // Fallback for auth middleware redirects
Route::post('/dang_nhap', [AuthController::class, 'xu_ly_dang_nhap']);
Route::get('/dang_ky', [AuthController::class, 'hien_thi_dang_ky'])->name('dang_ky');
Route::post('/dang_ky', [AuthController::class, 'xu_ly_dang_ky']);
Route::post('/dang_xuat', [AuthController::class, 'dang_xuat'])->name('dang_xuat');

// Dashboard quản trị
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/quan_ly', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Quản lý tài khoản (admin)
    Route::get('/quan_ly_tai_khoan/them', [TaiKhoanController::class, 'form_them_tai_khoan']);
    Route::get('/quan_ly_tai_khoan', [TaiKhoanController::class, 'danh_sach_tai_khoan']);
    Route::post('/quan_ly_tai_khoan/them', [TaiKhoanController::class, 'them_tai_khoan']);
    Route::post('/quan_ly_tai_khoan/sua/{id}', [TaiKhoanController::class, 'sua_tai_khoan']);
    Route::delete('/quan_ly_tai_khoan/xoa/{id}', [TaiKhoanController::class, 'xoa_tai_khoan']);

    // Quản lý danh mục
    Route::get('/quan_ly_danh_muc', [DanhMucController::class, 'danh_sach_danh_muc']);
    Route::post('/quan_ly_danh_muc/them', [DanhMucController::class, 'them_danh_muc']);
    Route::post('/quan_ly_danh_muc/sua/{id}', [DanhMucController::class, 'sua_danh_muc']);
    Route::delete('/quan_ly_danh_muc/xoa/{id}', [DanhMucController::class, 'xoa_danh_muc']);

    // Quản lý loại biến thể
    Route::get('/quan_ly_loai_bien_the', [LoaiBienTheController::class, 'danh_sach_loai_bien_the']);
    Route::post('/quan_ly_loai_bien_the/them', [LoaiBienTheController::class, 'them_loai_bien_the']);
    Route::post('/quan_ly_loai_bien_the/sua/{id}', [LoaiBienTheController::class, 'sua_loai_bien_the']);
    Route::delete('/quan_ly_loai_bien_the/xoa/{id}', [LoaiBienTheController::class, 'xoa_loai_bien_the']);

    // Quản lý sản phẩm
    Route::get('/quan_ly_san_pham/them', [SanPhamController::class, 'form_them_san_pham']);
    Route::get('/quan_ly_san_pham/sua/{id}', [SanPhamController::class, 'form_sua_san_pham']);
    Route::post('/quan_ly_san_pham/them', [SanPhamController::class, 'them_san_pham']);
    Route::post('/quan_ly_san_pham/sua/{id}', [SanPhamController::class, 'sua_san_pham']);
    Route::delete('/quan_ly_san_pham/xoa/{id}', [SanPhamController::class, 'xoa_san_pham']);
    Route::get('/quan_ly_san_pham', [SanPhamController::class, 'danh_sach_san_pham']);

    // Quản lý biến thể sản phẩm (giao diện danh sách chuyển về trang sản phẩm; API & POST giữ nguyên)
    Route::get('/quan_ly_bien_the', function () {
        return redirect('/quan_ly_san_pham')->with('success', 'Biến thể được quản lý ngay trong trang Sản phẩm.');
    });
    Route::get('/quan_ly_bien_the/loai_theo_danh_muc/{category_id}', [BienTheSanPhamController::class, 'lay_loai_bien_the_theo_danh_muc']);
    Route::get('/quan_ly_bien_the/loai_theo_san_pham/{product_id}', [BienTheSanPhamController::class, 'lay_loai_bien_the_theo_san_pham']);
    Route::post('/quan_ly_bien_the/them', [BienTheSanPhamController::class, 'them_bien_the']);
    Route::post('/quan_ly_bien_the/sua/{id}', [BienTheSanPhamController::class, 'sua_bien_the']);
    Route::delete('/quan_ly_bien_the/xoa/{id}', [BienTheSanPhamController::class, 'xoa_bien_the']);

    // Quản lý banner
    Route::get('/quan_ly_banner', [BannerController::class, 'danh_sach_banner']);
    Route::post('/quan_ly_banner/them', [BannerController::class, 'them_banner']);
    Route::post('/quan_ly_banner/sua/{id}', [BannerController::class, 'sua_banner']);
    Route::delete('/quan_ly_banner/xoa/{id}', [BannerController::class, 'xoa_banner']);
});

// Storefront
Route::get('/', [SanPhamController::class, 'trang_chu']);
Route::get('/san_pham/{id}', [SanPhamController::class, 'hien_thi_chi_tiet']);
Route::get('/danh_muc/{id}', [SanPhamController::class, 'danh_sach_theo_danh_muc']);
Route::get('/gioi-thieu', [PageController::class, 'gioi_thieu'])->name('gioi_thieu');

// Giỏ hàng
Route::middleware(['auth'])->group(function() {
    Route::get('/gio_hang', [GioHangController::class, 'hien_thi_gio_hang']);
    Route::post('/gio_hang/them', [GioHangController::class, 'them_san_pham_gio_hang']);
    Route::post('/gio_hang/cap_nhat', [GioHangController::class, 'cap_nhat_gio_hang']);
    Route::delete('/gio_hang/xoa/{id}', [GioHangController::class, 'xoa_san_pham_gio_hang']);
    Route::get('/gio_hang/tinh_tong_tien', [GioHangController::class, 'tinh_tong_tien']);
});

// Liên hệ
Route::get('/lien_he', [LienHeController::class, 'hien_thi_lien_he']);
Route::post('/lien_he', [LienHeController::class, 'gui_lien_he']);
