<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package\Translator\Loader;

use Ixocreate\Translation\Package\Repository\TranslationRepository;
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
     *
     * @throws NotFoundResourceException when the resource cannot be found
     * @throws InvalidResourceException  when the resource cannot be loaded
     * @return MessageCatalogue A MessageCatalogue instance
     *
     */
    public function load($resource, $locale, $domain = 'messages')
    {
        return new MessageCatalogue($locale, $this->translationRepository->loadTranslations($locale, $domain));
    }
}
