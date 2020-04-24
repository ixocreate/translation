<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Config;

use Ixocreate\Application\Configurator\ConfiguratorInterface;
use Ixocreate\Application\Service\ServiceRegistryInterface;

final class TranslationConfigurator implements ConfiguratorInterface
{
    private $extractDirectories = [];

    private $extractTarget = '';

    private $defaultCatalogue = '';

    /**
     * @param string $directory
     */
    public function addExtractDirectory(string $directory): void
    {
        $this->extractDirectories[] = $directory;
    }

    /**
     * @return array
     */
    public function extractDirectories(): array
    {
        return $this->extractDirectories;
    }

    /**
     * @param string $extractTarget
     */
    public function setExtractTarget(string $extractTarget): void
    {
        $this->extractTarget = $extractTarget;
    }

    /**
     * @return string
     */
    public function extractTarget(): string
    {
        return $this->extractTarget;
    }

    /**
     * @param string $defaultCatalogue
     */
    public function setDefaultCatalogue(string $defaultCatalogue): void
    {
        $this->defaultCatalogue = $defaultCatalogue;
    }

    /**
     * @return string
     */
    public function defaultCatalogue(): string
    {
        return $this->defaultCatalogue;
    }

    /**
     * @param ServiceRegistryInterface $serviceRegistry
     * @return void
     */
    public function registerService(ServiceRegistryInterface $serviceRegistry): void
    {
        $serviceRegistry->add(TranslationConfig::class, new TranslationConfig($this));
    }
}
