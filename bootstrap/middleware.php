<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Admin;

use Ixocreate\Application\Http\Middleware\MiddlewareConfigurator;
use Ixocreate\Translation\Action\CatalogueIndexAction;
use Ixocreate\Translation\Action\DetailAction;
use Ixocreate\Translation\Action\IndexAction;
use Ixocreate\Translation\Action\SaveAction;

/** @var MiddlewareConfigurator $middleware */
$middleware->addAction(CatalogueIndexAction::class);
$middleware->addAction(DetailAction::class);
$middleware->addAction(IndexAction::class);
$middleware->addAction(SaveAction::class);
