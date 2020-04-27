<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Translation;

use Ixocreate\Translation\Config\TranslationConfigurator;
use Ixocreate\Translation\TranslationBootstrapItem;
use PHPUnit\Framework\TestCase;

class TranslationBootstrapItemTest extends TestCase
{
    public function testGetConfigurator()
    {
        $item = new TranslationBootstrapItem();
        $this->assertInstanceOf(TranslationConfigurator::class, $item->getConfigurator());
    }

    public function testVariableName()
    {
        $item = new TranslationBootstrapItem();
        $this->assertEquals('translator', $item->getVariableName());
    }

    public function testFileName()
    {
        $item = new TranslationBootstrapItem();
        $this->assertEquals('translator.php', $item->getFileName());
    }
}
