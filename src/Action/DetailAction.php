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
namespace KiwiSuite\Translation\Action;

use KiwiSuite\Admin\Response\ApiSuccessResponse;
use KiwiSuite\Intl\LocaleManager;
use KiwiSuite\Translation\Entity\Definition;
use KiwiSuite\Translation\Entity\Translation;
use KiwiSuite\Translation\Repository\DefinitionRepository;
use KiwiSuite\Translation\Repository\TranslationRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DetailAction implements MiddlewareInterface
{
    /**
     * @var DefinitionRepository
     */
    private $definitionRepository;

    /**
     * @var LocaleManager
     */
    private $localeManager;
    /**
     * @var TranslationRepository
     */
    private $translationRepository;

    /**
     * CatalogueIndexAction constructor.
     * @param DefinitionRepository $definitionRepository
     * @param TranslationRepository $translationRepository
     * @param LocaleManager $localeManager
     */
    public function __construct(DefinitionRepository $definitionRepository, TranslationRepository $translationRepository, LocaleManager $localeManager)
    {
        $this->definitionRepository = $definitionRepository;
        $this->localeManager = $localeManager;
        $this->translationRepository = $translationRepository;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var Definition $definition */
        $definition = $this->definitionRepository->find($request->getAttribute("id"));

        if (empty($definition)) {
            return $handler->handle($request);
        }

        $intl = [];
        foreach ($this->localeManager->all() as $localeItem) {
            $intl[$localeItem['locale']] = [
                'locale' => $localeItem['locale'],
                'country' => \mb_strtolower(\Locale::getRegion($localeItem['locale'])),
                'message' => null,
                'id' => null,
            ];
        }

        $detail = [
            'id' => (string) $definition->id(),
            'placeholders' => $definition->placeholders(),
            'files' => $definition->files(),
            'name' => $definition->name(),
            'locales' => $intl,
        ];

        $result = $this->translationRepository->findBy(['definitionId' => $definition->id()]);

        /** @var Translation $translation */
        foreach ($result as $translation) {
            if (!\array_key_exists((string) $translation->locale(), $detail['locales'])) {
                continue;
            }

            $detail['locales'][$translation->locale()]['id'] = (string) $translation->id();
            $detail['locales'][$translation->locale()]['message'] = (string) $translation->message();
        }


        $detail['locales'] = \array_values($detail['locales']);

        return new ApiSuccessResponse($detail);
    }
}
