<?php
namespace KiwiSuite\Translation;
use KiwiSuite\Template\TemplateConfigurator;
use KiwiSuite\Translation\Template\TransExtension;
use KiwiSuite\Translation\Template\TransPluralExtension;

/** @var TemplateConfigurator $template */

$template->addExtension(TransExtension::class);
$template->addExtension(TransPluralExtension::class);

