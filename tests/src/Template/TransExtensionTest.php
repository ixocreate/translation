<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Translation\Template;

use Ixocreate\Translation\Template\TransExtension;
use Ixocreate\Translation\Translator\Translator;
use PHPUnit\Framework\TestCase;

class TransExtensionTest extends TestCase
{
    public function testName()
    {
        $this->assertEquals('trans', TransExtension::getName());
    }

    public function testTrans()
    {
        $translator = $this->createMock(Translator::class);
        $translator->expects($this->once())
            ->method('trans')
            ->with($this->equalTo('testName'), $this->equalTo(['param1', 'param2']), $this->equalTo('testCatalogue'), $this->equalTo('te_ST'));

        $extension = new TransExtension($translator);

        $extension('testName', ['param1', 'param2'], 'testCatalogue', 'te_ST');
    }
}
