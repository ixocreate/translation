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
namespace Ixocreate\Translation\Config;

use Ixocreate\Contract\Application\SerializableServiceInterface;

final class Config implements SerializableServiceInterface
{
    private $extractDirectories = [];

    private $extractTarget = "";

    private $defaultCatalogue = "";

    public function __construct(Configurator $configurator)
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

    public function extractTarget(): string
    {
        return $this->extractTarget;
    }

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
