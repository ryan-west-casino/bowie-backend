<?php
require_once __DIR__.'/../vendor/autoload.php';
(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();
date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));
$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);
class_alias('App\Facades\ProxyHelperFacade', 'ProxyHelper');
$aliases = [UserFacade::class => 'Foo'];
$app->withFacades();
$app->withEloquent();
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);
$app->singleton(\Illuminate\Contracts\Routing\ResponseFactory::class, function() {
    return new \Laravel\Lumen\Http\ResponseFactory();
});
$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);
$app->configure('app');
 $app->routeMiddleware([
     'auth' => App\Http\Middleware\Authenticate::class,
     'disableOnProduction' => App\Http\Middleware\DisableOnProduction::class,
 ]);

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);
$app->register(Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(Illuminate\Redis\RedisServiceProvider::class);
$app->register(Spatie\CollectionMacros\CollectionMacroServiceProvider::class);
//$app->register(BeyondCode\LaravelWebSockets\WebSocketsServiceProvider::class);

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
    require __DIR__.'/../routes/api.php';
    require __DIR__.'/../routes/casino.php';
});

$app->configure('jwt');
$app->configure('auth');
$app->configure('cache');
$app->configure('database');
$app->configure('broadcasting');
$app->configure('queue');

return $app;
