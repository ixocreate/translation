<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation;

use Ixocreate\Application\BootstrapItemInterface;
use Ixocreate\Application\ConfiguratorInterface;

final class TranslationBootstrapItem implements BootstrapItemInterface
{
    /**
     * @return mixed
     */
    public function getConfigurator(): ConfiguratorInterface
    {
        return new TranslationConfigurator();
    }

    /**
     * @return string
     */
    public function getVariableName(): string
    {
        return 'translator';
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return 'translator.php';
    }
}
