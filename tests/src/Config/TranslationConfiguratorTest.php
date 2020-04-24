<?php

declare(strict_types=1);

namespace Ixocreate\Test\Translation\Config;

use Ixocreate\Application\Service\ServiceRegistry;
use Ixocreate\Translation\Config\TranslationConfig;
use Ixocreate\Translation\Config\TranslationConfigurator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ixocreate\Translation\Config\TranslationConfigurator
 */
class TranslationConfiguratorTest extends TestCase
{
    public function testExtractDirectory()
    {
        $configurator = new TranslationConfigurator();
        $configurator->addExtractDirectory('/test');

        $this->assertEquals(['/test'], $configurator->extractDirectories());
    }

    public function testExtractTarget()
    {
        $configurator = new TranslationConfigurator();
        $configurator->setExtractTarget('testResource/translation');

        $this->assertEquals('testResource/translation', $configurator->extractTarget());
    }

    public function testDefaultCatalogue()
    {
        $configurator = new TranslationConfigurator();
        $configurator->setDefaultCatalogue('testCatalog');

        $this->assertEquals('testCatalog', $configurator->defaultCatalogue());
    }

    public function testRegisterService()
    {
        $configurator = new TranslationConfigurator();
        $configurator->addExtractDirectory('/test');
        $configurator->setExtractTarget('testResource/translation');
        $configurator->setDefaultCatalogue('testCatalog');

        $serviceRegistry = new ServiceRegistry();
        $configurator->registerService($serviceRegistry);

        /** @var TranslationConfig $config */
        $config = $serviceRegistry->get(TranslationConfig::class);

        $this->assertEquals(['/test'], $config->extractDirectories());
        $this->assertEquals('testResource/translation', $config->extractTarget());
        $this->assertEquals('testCatalog', $config->defaultCatalogue());
    }
}
