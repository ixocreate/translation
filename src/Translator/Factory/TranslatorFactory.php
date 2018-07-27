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
namespace KiwiSuite\Translation\Translator\Factory;

use KiwiSuite\Contract\ServiceManager\FactoryInterface;
use KiwiSuite\Contract\ServiceManager\ServiceManagerInterface;
use KiwiSuite\Database\Repository\Factory\RepositorySubManager;
use KiwiSuite\Intl\LocaleManager;
use KiwiSuite\Translation\Config\Config;
use KiwiSuite\Translation\Repository\TranslationRepository;
use KiwiSuite\Translation\Translator\Loader\DatabaseLoader;
use KiwiSuite\Translation\Translator\Translator;

final class TranslatorFactory implements FactoryInterface
{

    /**
     * @param ServiceManagerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return mixed
     */
    public function __invoke(ServiceManagerInterface $container, $requestedName, array $options = null)
    {
        /** @var LocaleManager $localeManager */
        $localeManager = $container->get(LocaleManager::class);

        /** @var Config $translationConfig */
        $translationConfig = $container->get(Config::class);

        $translator = new \Symfony\Component\Translation\Translator($localeManager->defaultLocale());
        $translator->addLoader('database', new DatabaseLoader($container->get(RepositorySubManager::class)->get(TranslationRepository::class)));
        foreach ($localeManager->all() as $info) {
            $translator->addResource('database', 'database', $info['locale'], $translationConfig->defaultCatalogue());
        }

        return new Translator($translator, $translationConfig);
    }
}
