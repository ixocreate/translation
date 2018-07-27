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
namespace KiwiSuite\Translation;

use KiwiSuite\CommonTypes\Entity\UuidType;
use KiwiSuite\Database\ORM\Metadata\AbstractMetadata;

final class TranslationMetadata extends AbstractMetadata
{
    protected function buildMetadata(): void
    {
        $builder = $this->getBuilder();
        $builder->setTable('translation_translation');

        $this->setFieldBuilder(
            'id',
            $builder->createField('id', UuidType::class)
                ->makePrimaryKey()
        )->build();

        $this->setFieldBuilder(
            'definitionId',
            $builder->createField('definitionId', 'string')
        )->build();

        $this->setFieldBuilder(
            'locale',
            $builder->createField('locale', 'string')
        )->build();

        $this->setFieldBuilder(
            'message',
            $builder->createField('message', 'string')
        )->build();
    }
}
