<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Admin;

use Ixocreate\Database\Repository\RepositoryConfigurator;
use Ixocreate\Translation\Repository\DefinitionRepository;
use Ixocreate\Translation\Repository\TranslationRepository;

/** @var RepositoryConfigurator $repository */

$repository->addRepository(DefinitionRepository::class);
$repository->addRepository(TranslationRepository::class);
