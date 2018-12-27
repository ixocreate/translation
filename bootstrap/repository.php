<?php
declare(strict_types=1);

namespace Ixocreate\Admin;

/** @var RepositoryConfigurator $repository */
use Ixocreate\Database\Repository\RepositoryConfigurator;
use Ixocreate\Translation\Repository\DefinitionRepository;
use Ixocreate\Translation\Repository\TranslationRepository;

$repository->addRepository( DefinitionRepository::class);
$repository->addRepository( TranslationRepository::class);
