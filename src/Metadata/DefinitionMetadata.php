<?php
/**
 * kiwi-suite/translation (https://github.com/kiwi-suite/translation)
 *
 * @package kiwi-suite/translation
 * @link https://github.com/kiwi-suite/translation
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);
namespace KiwiSuite\Translation\Metadata;

use Doctrine\DBAL\Types\Type;
use KiwiSuite\CommonTypes\Entity\UuidType;
use KiwiSuite\Database\ORM\Metadata\AbstractMetadata;

final class DefinitionMetadata extends AbstractMetadata
{
    protected function buildMetadata(): void
    {
        $builder = $this->getBuilder();
        $builder->setTable('translation_definition');

        $this->setFieldBuilder(
            'id',
            $builder->createField('id', UuidType::class)
                ->makePrimaryKey()
        )->build();

        $this->setFieldBuilder(
            'name',
            $builder->createField('name', 'string')
                ->makePrimaryKey()
        )->build();

        $this->setFieldBuilder(
            'catalogue',
            $builder->createField('catalogue', 'string')
        )->build();

        $this->setFieldBuilder(
            'files',
            $builder->createField('files', Type::JSON)
        )->build();

        $this->setFieldBuilder(
            'placeholders',
            $builder->createField('placeholders', Type::JSON)
        )->build();
    }
}
