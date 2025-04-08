<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
  /**
   * This constant defines where users are redirected after login.
   * You can change it to match your desired redirect route.
   */
  public const HOME = '/';

  /**
   * Define your route model bindings, pattern filters, etc.
   */
  public function boot(): void
  {
    $this->routes(function () {
      Route::middleware('web')
        ->group(base_path('routes/web.php'));

      Route::middleware('api')
        ->prefix('api')
        ->group(base_path('routes/api.php'));
    });
  }
}