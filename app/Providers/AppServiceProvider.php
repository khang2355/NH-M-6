<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->dam_bao_lien_ket_storage();

        View::composer('partials.navbar', function ($view) {
            $cartCount = 0;
            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->first();
                $cartCount = $cart ? (int) $cart->items()->sum('so_luong') : 0;
            }
            $view->with('cartCount', $cartCount);
        });
    }

    /**
     * Tạo symlink public/storage → storage/app/public nếu chưa có (ảnh upload hiển thị được).
     */
    private function dam_bao_lien_ket_storage(): void
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return;
        }

        $link = public_path('storage');
        if (File::exists($link)) {
            return;
        }

        try {
            Artisan::call('storage:link');
        } catch (\Throwable) {
            // Windows / quyền: chạy thủ công: php artisan storage:link
        }
    }
}
