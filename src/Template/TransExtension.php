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
namespace Ixocreate\Translation\Template;

use Ixocreate\Contract\Template\ExtensionInterface;
use Ixocreate\Translation\Translator\Translator;

final class TransExtension implements ExtensionInterface
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
        return 'trans';
    }

    /**
     * @param string $name
     * @param array $parameters
     * @param null|string $catalogue
     * @param null|string $locale
     * @return string
     */
    public function __invoke(string $name, array $parameters = [], ?string $catalogue = null, ?string $locale = null)
    {
        return $this->translator->trans($name, $parameters, $catalogue, $locale);
    }
}
