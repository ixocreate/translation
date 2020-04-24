<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Config;

use Ixocreate\Application\Service\SerializableServiceInterface;

final class TranslationConfig implements SerializableServiceInterface
{
    /**
     * @var array
     */
    private $extractDirectories;

    /**
     * @var string
     */
    private $extractTarget;

    /**
     * @var string
     */
    private $defaultCatalogue;

    public function __construct(TranslationConfigurator $configurator)
    {
        $this->extractTarget = $configurator->extractTarget();
        $this->defaultCatalogue = $configurator->defaultCatalogue();
        $this->extractDirectories = $configurator->extractDirectories();
    }

    /**
     * @return array
     */
    public function extractDirectories(): array
    {
        return $this->extractDirectories;
    }

    /**
     * @return string
     */
    public function extractTarget(): string
    {
        return $this->extractTarget;
    }

    /**
     * @return string
     */
    public function defaultCatalogue(): string
    {
        return $this->defaultCatalogue;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return \serialize([
            'extractTarget' => $this->extractTarget,
            'extractDirectories' => $this->extractDirectories,
            'defaultCatalogue' => $this->defaultCatalogue,
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $unserialized = \unserialize($serialized);

        $this->extractTarget = $unserialized['extractTarget'];
        $this->extractDirectories = $unserialized['extractDirectories'];
        $this->defaultCatalogue = $unserialized['defaultCatalogue'];
    }
}
