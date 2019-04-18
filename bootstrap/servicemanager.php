<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Translation;

use Ixocreate\Package\Translation\Translator\Factory\TranslatorFactory;
use Ixocreate\Package\Translation\Translator\Translator;

/** @var \Ixocreate\ServiceManager\ServiceManagerConfigurator $serviceManager */

$serviceManager->addFactory(Translator::class, TranslatorFactory::class);
