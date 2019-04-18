<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package\Translator\Factory;

use Ixocreate\ServiceManager\FactoryInterface;
use Ixocreate\ServiceManager\ServiceManagerInterface;
use Ixocreate\Database\Package\Repository\Factory\RepositorySubManager;
use Ixocreate\Intl\Package\LocaleManager;
use Ixocreate\Translation\Package\Config\Config;
use Ixocreate\Translation\Package\Repository\TranslationRepository;
use Ixocreate\Translation\Package\Translator\Loader\DatabaseLoader;
use Ixocreate\Translation\Package\Translator\Translator;

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
