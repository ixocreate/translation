<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Translation\Template;

use Ixocreate\Translation\Template\TransPluralExtension;
use Ixocreate\Translation\Translator\Translator;
use PHPUnit\Framework\TestCase;

class TransPluralExtensionTest extends TestCase
{
    public function testName()
    {
        $this->assertEquals('transPlural', TransPluralExtension::getName());
    }

    public function testTrans()
    {
        $translator = $this->createMock(Translator::class);
        $translator->expects($this->once())
            ->method('transPlural')
            ->with(
                $this->equalTo('name'),
                $this->equalTo(5),
                $this->equalTo(['param1', 'param2']),
                $this->equalTo('testCatalog'),
                $this->equalTo('te_ST')
            );

        $extension = new TransPluralExtension($translator);

        $extension('name', 5, ['param1', 'param2'], 'testCatalog', 'te_ST');
    }
}
