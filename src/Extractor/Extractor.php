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

namespace Ixocreate\Translation\Extractor;

use Ixocreate\Translation\Config\Config;
use PhpParser\Error;
use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class Extractor
{
    public function extract(Config $config, array $files): Collector
    {
        $collector = new Collector();

        $files = $this->extractFiles($files);

        $parser = (new ParserFactory())->create(ParserFactory::ONLY_PHP7);
        foreach ($files as $file) {
            try {
                $tokens = $parser->parse($file->getContents());

                $traverser = new NodeTraverser();
                $traverser->addVisitor(new Visitor($collector, $file->getFilename(), $config));
                $traverser->traverse($tokens);
            } catch (Error $error) {
            }
        }

        return $collector;
    }

    /**
     * @param array $files
     * @return SplFileInfo[]
     */
    private function extractFiles(array $files)
    {
        $extractedFiles = [];

        foreach ($files as $file) {
            if (\is_file($file)) {
                if ($this->canBeExtracted($file)) {
                    $extractedFiles[] = $this->toSplFileInfo($file);
                }
            } elseif (\is_dir($file)) {
                $extractedFiles = \array_merge($extractedFiles, \iterator_to_array((new Finder())->files()->name('*.php')->name('*.phtml')->in($file)->getIterator()));
            }
        }

        return $extractedFiles;
    }

    private function toSplFileInfo(string $file): SplFileInfo
    {
        return new SplFileInfo($file, "", "");
    }

    private function canBeExtracted($file)
    {
        return \is_file($file) && \in_array(\pathinfo($file, PATHINFO_EXTENSION), ['php', 'phtml']);
    }
}
