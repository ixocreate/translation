<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Template;

use Ixocreate\Template\Extension\ExtensionInterface;
use Ixocreate\Translation\Translator\Translator;

final class TransExtension implements ExtensionInterface
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * TranslateExtension constructor.
     *
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
