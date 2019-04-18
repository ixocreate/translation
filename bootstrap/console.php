<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Translation;

/** @var ConsoleConfigurator $console */

use Ixocreate\Application\Console\ConsoleConfigurator;
use Ixocreate\Package\Translation\Console\ExtractCommand;
use Ixocreate\Package\Translation\Console\PrepareCommand;

$console->addCommand(ExtractCommand::class);
$console->addCommand(PrepareCommand::class);
