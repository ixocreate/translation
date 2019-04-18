<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Translation;

use Ixocreate\Package\Template\TemplateConfigurator;
use Ixocreate\Package\Translation\Template\TransExtension;
use Ixocreate\Package\Translation\Template\TransPluralExtension;

/** @var TemplateConfigurator $template */

$template->addExtension(TransExtension::class);
$template->addExtension(TransPluralExtension::class);
