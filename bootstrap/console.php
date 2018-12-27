<?php
namespace Ixocreate\Translation;

/** @var ConsoleConfigurator $console */
use Ixocreate\ApplicationConsole\ConsoleConfigurator;
use Ixocreate\Translation\Console\ExtractCommand;
use Ixocreate\Translation\Console\PrepareCommand;

$console->addCommand(ExtractCommand::class);
$console->addCommand(PrepareCommand::class);
