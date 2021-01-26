<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Translation;

use Ixocreate\Translation\Package;
use Ixocreate\Translation\TranslationBootstrapItem;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    /**
     * @covers \Ixocreate\Translation\Package
     */
    public function testPackage()
    {
        $package = new Package();

        $this->assertSame([TranslationBootstrapItem::class], $package->getBootstrapItems());

        $this->assertDirectoryExists($package->getBootstrapDirectory());
        $this->assertEmpty($package->getDependencies());
    }
}
