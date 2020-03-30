<?php

namespace Seed\Packagetest;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PackagetestServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        // 单例绑定服务
        $this->app->singleton('packagetest', function ($app) {
            return new Packagetest($app['session'], $app['config']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // 读取视图
        $this->loadViewsFrom(__DIR__ . '/views', 'Packagetest');

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/packagetest'),  // 发布视图目录到resources 下
            __DIR__ . '/config/packagetest.php' => config_path('packagetest.php'), // 发布配置文件到 laravel 的config 下
        ]);

        $this->app['packagetest']->register();
    }

    public function provides()
    {
        // 因为延迟加载 所以要定义 provides 函数 具体参考laravel 文档
        return ['packagetest'];
    }
}
