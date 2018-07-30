<?php
declare(strict_types=1);

namespace KiwiSuite\Translation;

/** @var \KiwiSuite\ServiceManager\ServiceManagerConfigurator $serviceManager */
use KiwiSuite\Translation\Translator\Factory\TranslatorFactory;
use KiwiSuite\Translation\Translator\Translator;

$serviceManager->addFactory(Translator::class, TranslatorFactory::class);
