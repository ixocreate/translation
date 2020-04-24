<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Translation\Config;

use Ixocreate\Translation\Config\TranslationConfig;
use Ixocreate\Translation\Config\TranslationConfigurator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ixocreate\Translation\Config\TranslationConfig
 */
class TranslationConfigTest extends TestCase
{
    public function testExtractDirectory()
    {
        $configurator = new TranslationConfigurator();
        $configurator->addExtractDirectory('/test');

        $config = new TranslationConfig($configurator);

        $this->assertEquals(['/test'], $config->extractDirectories());
    }

    public function testExtractTarget()
    {
        $configurator = new TranslationConfigurator();
        $configurator->setExtractTarget('testResource/translation');

        $config = new TranslationConfig($configurator);

        $this->assertEquals('testResource/translation', $config->extractTarget());
    }

    public function testDefaultCatalogue()
    {
        $configurator = new TranslationConfigurator();
        $configurator->setDefaultCatalogue('testCatalog');

        $config = new TranslationConfig($configurator);

        $this->assertEquals('testCatalog', $config->defaultCatalogue());
    }

    public function testSerialize()
    {
        $configurator = new TranslationConfigurator();
        $configurator->addExtractDirectory('/test');
        $configurator->setExtractTarget('testResource/translation');
        $configurator->setDefaultCatalogue('testCatalog');

        $config = new TranslationConfig($configurator);

        $data = [
            'extractTarget' => 'testResource/translation',
            'extractDirectories' => ['/test'],
            'defaultCatalogue' => 'testCatalog',
        ];

        $this->assertEquals(\serialize($data), $config->serialize());
    }

    public function testUnserialize()
    {
        $configurator = new TranslationConfigurator();
        $configurator->addExtractDirectory('/test');
        $configurator->setExtractTarget('testResource/translation');
        $configurator->setDefaultCatalogue('testCatalog');

        $config = new TranslationConfig($configurator);

        $serialization = \serialize($config);
        /** @var TranslationConfig $restoredConfig */
        $restoredConfig = \unserialize($serialization);

        $this->assertEquals(['/test'], $restoredConfig->extractDirectories());
        $this->assertEquals('testResource/translation', $restoredConfig->extractTarget());
        $this->assertEquals('testCatalog', $restoredConfig->defaultCatalogue());
    }
}
