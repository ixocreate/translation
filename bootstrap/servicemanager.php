<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package;

use Ixocreate\Translation\Package\Translator\Factory\TranslatorFactory;
use Ixocreate\Translation\Package\Translator\Translator;

/** @var \Ixocreate\ServiceManager\ServiceManagerConfigurator $serviceManager */

$serviceManager->addFactory(Translator::class, TranslatorFactory::class);
