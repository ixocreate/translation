<?php
namespace KiwiSuite\Translation;

/** @var ConsoleConfigurator $console */
use KiwiSuite\ApplicationConsole\ConsoleConfigurator;
use KiwiSuite\Translation\Console\ExtractCommand;
use KiwiSuite\Translation\Console\PrepareCommand;

$console->addCommand(ExtractCommand::class);
$console->addCommand(PrepareCommand::class);
