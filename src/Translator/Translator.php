<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Translation\Translator;

use Ixocreate\Package\Translation\Config\Config;

final class Translator
{
    /**
     * @var \Symfony\Component\Translation\Translator
     */
    private $translator;

    /**
     * @var Config
     */
    private $config;

    /**
     * Translator constructor.
     * @param \Symfony\Component\Translation\Translator $translator
     * @param Config $config
     */
    public function __construct(\Symfony\Component\Translation\Translator $translator, Config $config)
    {
        $this->translator = $translator;
        $this->config = $config;
    }

    /**
     * @param string $name
     * @param array $parameters
     * @param null|string $catalogue
     * @param null|string $locale
     * @return string
     */
    public function trans(string $name, array $parameters = [], ?string $catalogue = null, ?string $locale = null): string
    {
        if ($catalogue === null) {
            $catalogue = $this->config->defaultCatalogue();
        }

        if ($locale === null) {
            $locale = \Locale::getDefault();
        }

        return $this->translator->trans($name, $parameters, $catalogue, $locale);
    }

    /**
     * @param string $name
     * @param int $number
     * @param array $parameters
     * @param null|string $catalogue
     * @param null|string $locale
     * @return string
     */
    public function transPlural(string $name, int $number, array $parameters = [], ?string $catalogue = null, ?string $locale = null)
    {
        if ($catalogue === null) {
            $catalogue = $this->config->defaultCatalogue();
        }

        if ($locale === null) {
            $locale = \Locale::getDefault();
        }

        return $this->translator->transChoice($name, $number, $parameters, $catalogue, $locale);
    }
}
