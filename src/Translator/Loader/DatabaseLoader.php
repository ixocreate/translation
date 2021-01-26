<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Translator\Loader;

use Ixocreate\Translation\Repository\TranslationRepository;
use Symfony\Component\Translation\Exception\InvalidResourceException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;

final class DatabaseLoader implements LoaderInterface
{
    /**
     * @var TranslationRepository
     */
    private $translationRepository;

    public function __construct(TranslationRepository $translationRepository)
    {
        $this->translationRepository = $translationRepository;
    }

    /**
     * Loads a locale.
     *
     * @param mixed $resource A resource
     * @param string $locale A locale
     * @param string $domain The domain
     * @return MessageCatalogue A MessageCatalogue instance
     * @throws InvalidResourceException when the resource cannot be loaded
     * @throws NotFoundResourceException when the resource cannot be found
     */
    public function load($resource, string $locale, $domain = 'messages')
    {
        return new MessageCatalogue($locale, $this->translationRepository->loadTranslations($locale, $domain));
    }
}
