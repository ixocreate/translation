<?php
declare(strict_types=1);

namespace Ixocreate\Translation;

/** @var \Ixocreate\ServiceManager\ServiceManagerConfigurator $serviceManager */
use Ixocreate\Translation\Translator\Factory\TranslatorFactory;
use Ixocreate\Translation\Translator\Translator;

$serviceManager->addFactory(Translator::class, TranslatorFactory::class);
