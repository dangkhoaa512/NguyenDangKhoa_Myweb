<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use App\Models\Brand;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Phân trang Bootstrap 5
        Paginator::useBootstrapFive();

        // Chỉ tải dữ liệu cho Navbar
        View::composer('client._partials.navbar', function ($view) {
            $categories = Cache::remember(
                'navbar_categories',
                now()->addHours(1),
                function () {
                    return Category::select('cateid', 'catename', 'slug')
                        ->where('status', 1)
                        ->orderBy('catename')
                        ->take(10)
                        ->get();
                }
            );

            $brands = Cache::remember(
                'navbar_brands',
                now()->addHours(1),
                function () {
                    return Brand::select('id', 'brandname', 'slug')
                        ->where('status', 1)
                        ->orderBy('brandname')
                        ->take(10)
                        ->get();
                }
            );

            $view->with(compact('categories', 'brands'));
        });
    }
}