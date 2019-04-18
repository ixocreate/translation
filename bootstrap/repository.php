<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Admin;

use Ixocreate\Package\Database\Repository\RepositoryConfigurator;
use Ixocreate\Package\Translation\Repository\DefinitionRepository;
use Ixocreate\Package\Translation\Repository\TranslationRepository;

/** @var RepositoryConfigurator $repository */

$repository->addRepository(DefinitionRepository::class);
$repository->addRepository(TranslationRepository::class);
