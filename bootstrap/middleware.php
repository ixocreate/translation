<?php
declare(strict_types=1);

namespace Ixocreate\Admin;

/** @var MiddlewareConfigurator $middleware */
use Ixocreate\ApplicationHttp\Middleware\MiddlewareConfigurator;

$middleware->addDirectory(__DIR__ . '/../src/Action', true);
