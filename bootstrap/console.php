<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package;

/** @var ConsoleConfigurator $console */

use Ixocreate\Application\Console\ConsoleConfigurator;
use Ixocreate\Translation\Package\Console\ExtractCommand;
use Ixocreate\Translation\Package\Console\PrepareCommand;

$console->addCommand(ExtractCommand::class);
$console->addCommand(PrepareCommand::class);
