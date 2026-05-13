<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*

|--------------------------------------------------------------------------
| Check If Application Is Under Maintenance
|--------------------------------------------------------------------------

|
| Если приложение находится на обслуживании, показываем страницу "503 Service Unavailable"
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*

|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------

|
| Laravel использует Composer для автозагрузки классов.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*

|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------

|
| Загружаем приложение, обрабатываем запрос и отправляем ответ.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);