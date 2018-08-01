<?php
declare(strict_types=1);

namespace KiwiSuite\Admin;

/** @var MiddlewareConfigurator $middleware */
use KiwiSuite\ApplicationHttp\Middleware\MiddlewareConfigurator;

$middleware->addDirectory(__DIR__ . '/../src/Action', true);
