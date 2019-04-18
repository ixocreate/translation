<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation;

use Ixocreate\Application\Console\ConsoleConfigurator;
use Ixocreate\Translation\Console\ExtractCommand;
use Ixocreate\Translation\Console\PrepareCommand;

/** @var ConsoleConfigurator $console */

$console->addCommand(ExtractCommand::class);
$console->addCommand(PrepareCommand::class);
