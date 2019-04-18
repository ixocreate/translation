<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Admin\Package;

/** @var MiddlewareConfigurator $middleware */

use Ixocreate\Application\Http\Middleware\MiddlewareConfigurator;

$middleware->addDirectory(__DIR__ . '/../src/Action', true);
