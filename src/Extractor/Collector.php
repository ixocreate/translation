<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Translation\Extractor;

use Traversable;

final class Collector implements \JsonSerializable, \IteratorAggregate
{
    /**
     * @var array
     */
    private $translations = [];

    public static function fromJson(array $translations): Collector
    {
        $collector = new Collector();
        foreach ($translations as $catalogueData) {
            $collector->translations[$catalogueData['name']] = [
                'name' => $catalogueData['name'],
                'translations' => [],
            ];
            foreach ($catalogueData['translations'] as $translationData) {
                $collector->translations[$catalogueData['name']]['translations'][$translationData['name']] = $translationData;
            }
        }

        return $collector;
    }

    /**
     * @param string $translation
     * @param string $file
     * @param array $placeholders
     * @param string $catalogue
     */
    public function add(string $translation, string $file, array $placeholders, string $catalogue): void
    {
        $placeholders = \array_values($placeholders);

        if (!\array_key_exists($catalogue, $this->translations)) {
            $this->translations[$catalogue] = [
                'name' => $catalogue,
                'translations' => [],
            ];
        }

        if (!\array_key_exists($translation, $this->translations[$catalogue])) {
            $translationData = [
                'name' => $translation,
                'catalogue' => $catalogue,
                'files' => [],
                'placeholders' => [],
            ];
        } else {
            $translationData = $this->translations[$catalogue]['translations'][$translation];
        }

        $translationData['files'][] = $file;
        $translationData['placeholders'] = \array_merge($translationData['placeholders'], $placeholders);

        $translationData['files'] = \array_unique($translationData['files']);
        $translationData['placeholders'] = \array_unique($translationData['placeholders']);

        $this->translations[$catalogue]['translations'][$translation] = $translationData;
    }

    public function toArray(): array
    {
        $items = \array_values($this->translations);
        foreach ($items as $key => $item) {
            $items[$key]['translations'] = \array_values($item['translations']);
        }

        return $items;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return Traversable|void
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }
}
