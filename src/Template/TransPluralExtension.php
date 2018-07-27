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
namespace KiwiSuite\Translation\Template;

use KiwiSuite\Contract\Template\ExtensionInterface;
use KiwiSuite\Translation\Translator\Translator;

final class TransPluralExtension implements ExtensionInterface
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * TranslateExtension constructor.
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'transPlural';
    }

    /**
     * @param string $name
     * @param int $number
     * @param array $parameters
     * @param null|string $catalogue
     * @param null|string $locale
     * @return string
     */
    public function __invoke(string $name, int $number, array $parameters = [], ?string $catalogue = null, ?string $locale = null)
    {
        return $this->translator->transPlural($name, $number, $parameters, $catalogue, $locale);
    }
}
