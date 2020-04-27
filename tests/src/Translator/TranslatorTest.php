<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Translation\Translator;

use Ixocreate\Translation\Config\TranslationConfig;
use Ixocreate\Translation\Translator\Translator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\Translator as SymfonyTranslator;

class TranslatorTest extends TestCase
{
    public function testTransDefault()
    {
        $symTranslator = $this->createMock(SymfonyTranslator::class);
        $symTranslator->expects($this->once())
            ->method('trans')
            ->with($this->equalTo('testName'), $this->equalTo(['param1', 'param2']), $this->equalTo('testCatalogue'), $this->equalTo('te_ST'))
            ->willReturn('testTranslation');

        $config = $this->createMock(TranslationConfig::class);
        $config
            ->expects($this->once())
            ->method('defaultCatalogue')
            ->willReturn('testCatalogue');

        \Locale::setDefault('te_ST');

        $translator = new Translator($symTranslator, $config);
        $translation = $translator->trans('testName', ['param1', 'param2']);

        $this->assertEquals('testTranslation', $translation);
    }

    public function testTrans()
    {
        $symTranslator = $this->createMock(SymfonyTranslator::class);
        $symTranslator->expects($this->once())
            ->method('trans')
            ->with($this->equalTo('testName'), $this->equalTo(['param1', 'param2']), $this->equalTo('testCatalogue'), $this->equalTo('te_ST'))
            ->willReturn('testTranslation');

        $config = $this->createMock(TranslationConfig::class);
        $config
            ->expects($this->never())
            ->method('defaultCatalogue');

        \Locale::setDefault('te_TE');

        $translator = new Translator($symTranslator, $config);
        $translation = $translator->trans('testName', ['param1', 'param2'], 'testCatalogue', 'te_ST');

        $this->assertEquals('testTranslation', $translation);
    }

    public function testTransPluralDefault()
    {
        $symTranslator = $this->createMock(SymfonyTranslator::class);
        $symTranslator->expects($this->once())
            ->method('trans')
            ->with($this->equalTo('testName'), $this->equalTo(['count' => 5, 'param1', 'param2']), $this->equalTo('testCatalogue'), $this->equalTo('te_ST'))
            ->willReturn('testTranslation');

        $config = $this->createMock(TranslationConfig::class);
        $config
            ->expects($this->once())
            ->method('defaultCatalogue')
            ->willReturn('testCatalogue');

        \Locale::setDefault('te_ST');

        $translator = new Translator($symTranslator, $config);
        $translation = $translator->transPlural('testName', 5, ['param1', 'param2']);

        $this->assertEquals('testTranslation', $translation);
    }

    public function testTransPlural()
    {
        $symTranslator = $this->createMock(SymfonyTranslator::class);
        $symTranslator->expects($this->once())
            ->method('trans')
            ->with($this->equalTo('testName'), $this->equalTo(['count' => 5, 'param1', 'param2']), $this->equalTo('testCatalogue'), $this->equalTo('te_ST'))
            ->willReturn('testTranslation');

        $config = $this->createMock(TranslationConfig::class);
        $config
            ->expects($this->never())
            ->method('defaultCatalogue');

        \Locale::setDefault('te_TE');

        $translator = new Translator($symTranslator, $config);
        $translation = $translator->transPlural('testName', 5, ['param1', 'param2'], 'testCatalogue', 'te_ST');

        $this->assertEquals('testTranslation', $translation);
    }
}
