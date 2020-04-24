<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation;

use Ixocreate\Application\Bootstrap\BootstrapItemInterface;
use Ixocreate\Application\Configurator\ConfiguratorInterface;
use Ixocreate\Translation\Config\TranslationConfigurator;

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
