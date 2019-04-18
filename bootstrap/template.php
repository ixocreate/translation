<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package;

use Ixocreate\Template\Package\TemplateConfigurator;
use Ixocreate\Translation\Package\Template\TransExtension;
use Ixocreate\Translation\Package\Template\TransPluralExtension;

/** @var TemplateConfigurator $template */

$template->addExtension(TransExtension::class);
$template->addExtension(TransPluralExtension::class);
