<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation;

use Ixocreate\Template\TemplateConfigurator;
use Ixocreate\Translation\Template\TransExtension;
use Ixocreate\Translation\Template\TransPluralExtension;

/** @var TemplateConfigurator $template */
$template->addExtension(TransExtension::class);
$template->addExtension(TransPluralExtension::class);
