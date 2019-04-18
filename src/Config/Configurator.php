<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package\Config;

use Ixocreate\Application\ConfiguratorInterface;
use Ixocreate\Application\ServiceRegistryInterface;

final class Configurator implements ConfiguratorInterface
{
    private $extractDirectories = [];

    private $extractTarget = "";

    private $defaultCatalogue = "";

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
        $serviceRegistry->add(Config::class, new Config($this));
    }
}
