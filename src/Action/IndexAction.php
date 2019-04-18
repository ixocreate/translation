<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package\Action;

use Doctrine\Common\Collections\Criteria;
use Ixocreate\Admin\Package\Response\ApiSuccessResponse;
use Ixocreate\Intl\Package\LocaleManager;
use Ixocreate\Translation\Package\Entity\Definition;
use Ixocreate\Translation\Package\Entity\Translation;
use Ixocreate\Translation\Package\Repository\DefinitionRepository;
use Ixocreate\Translation\Package\Repository\TranslationRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class IndexAction implements MiddlewareInterface
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
        $offset = 0;
        $limit = 25;

        if (!empty($request->getQueryParams()['limit']) && \is_scalar($request->getQueryParams()['limit'])) {
            $limit = (int) $request->getQueryParams()['limit'];
        }

        if (!empty($request->getQueryParams()['offset']) && \is_scalar($request->getQueryParams()['offset'])) {
            $offset = (int) $request->getQueryParams()['offset'];
        }

        if ($limit > 500 || empty($limit)) {
            $limit = 25;
        }

        $criteria = new Criteria();
        $criteria->setFirstResult($offset);
        $criteria->setMaxResults($limit);
        $criteria->orderBy(['name' => 'ASC']);
        $criteria->andWhere(Criteria::expr()->eq('catalogue', $request->getAttribute('catalogue')));

        if (!empty($request->getQueryParams()['search']) && \is_string($request->getQueryParams()['search'])) {
            $criteria->andWhere(Criteria::expr()->contains('name', $request->getQueryParams()['search']));
        }

        $data = [];
        $result = $this->definitionRepository->matching($criteria);
        /** @var Definition $definition */
        foreach ($result as $definition) {
            $intl = [];
            foreach ($this->localeManager->all() as $localeItem) {
                $intl[$localeItem['locale']] = [
                    'locale' => $localeItem['locale'],
                    'country' => \mb_strtolower(\Locale::getRegion($localeItem['locale'])),
                    'translated' => false,
                ];
            }

            $data[(string) $definition->id()] = [
                'id' => $definition->id(),
                'name' => $definition->name(),
                'locales' => $intl,
            ];
        }

        $result = $this->translationRepository->findBy(['definitionId' => \array_keys($data)]);
        /** @var Translation $translation */
        foreach ($result as $translation) {
            if (!\array_key_exists((string) $translation->definitionId(), $data)) {
                continue;
            }

            if (!\array_key_exists((string) $translation->locale(), $data[(string) $translation->definitionId()]['locales'])) {
                continue;
            }

            $data[(string) $translation->definitionId()]['locales'][$translation->locale()]['translated'] = (!empty($translation->message()));
        }


        foreach ($data as $key => $item) {
            $data[$key]['locales'] = \array_values($data[$key]['locales']);
        }

        return new ApiSuccessResponse([
            'items' => \array_values($data),
            'meta' => [
                'count' => $this->definitionRepository->count(['catalogue' => $request->getAttribute('catalogue')]),
            ],
        ]);
    }
}
