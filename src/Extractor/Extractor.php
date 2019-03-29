<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
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
    /**
     * @param Config $config
     * @param array $files
     * @return Collector
     */
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
    private function extractFiles(array $files): array
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

    /**
     * @param string $file
     * @return SplFileInfo
     */
    private function toSplFileInfo(string $file): SplFileInfo
    {
        return new SplFileInfo($file, '', '');
    }

    /**
     * @param string $file
     * @return bool
     */
    private function canBeExtracted(string $file): bool
    {
        return \is_file($file) && \in_array(\pathinfo($file, PATHINFO_EXTENSION), ['php', 'phtml']);
    }
}
