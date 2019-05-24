<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Admin;

use Ixocreate\Application\Http\Middleware\MiddlewareConfigurator;

/** @var MiddlewareConfigurator $middleware */
$middleware->addDirectory(__DIR__ . '/../src/Action', true);
