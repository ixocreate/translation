<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Admin\Package;

use Ixocreate\Database\Package\Repository\RepositoryConfigurator;
use Ixocreate\Translation\Package\Repository\DefinitionRepository;
use Ixocreate\Translation\Package\Repository\TranslationRepository;

/** @var RepositoryConfigurator $repository */

$repository->addRepository(DefinitionRepository::class);
$repository->addRepository(TranslationRepository::class);
