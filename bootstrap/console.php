<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation;

/** @var ConsoleConfigurator $console */

use Ixocreate\ApplicationConsole\ConsoleConfigurator;
use Ixocreate\Translation\Console\ExtractCommand;
use Ixocreate\Translation\Console\PrepareCommand;

$console->addCommand(ExtractCommand::class);
$console->addCommand(PrepareCommand::class);
