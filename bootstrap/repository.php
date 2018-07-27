<?php
declare(strict_types=1);

namespace KiwiSuite\Admin;

/** @var RepositoryConfigurator $repository */
use KiwiSuite\Database\Repository\RepositoryConfigurator;
use KiwiSuite\Translation\Repository\DefinitionRepository;
use KiwiSuite\Translation\Repository\TranslationRepository;

$repository->addRepository( DefinitionRepository::class);
$repository->addRepository( TranslationRepository::class);
