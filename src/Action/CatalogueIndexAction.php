<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Action;

use Doctrine\ORM\Query\Expr\Join;
use Ixocreate\Admin\Response\ApiSuccessResponse;
use Ixocreate\Intl\LocaleManager;
use Ixocreate\Translation\Entity\Definition;
use Ixocreate\Translation\Entity\Translation;
use Ixocreate\Translation\Repository\DefinitionRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class CatalogueIndexAction implements MiddlewareInterface
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
     * CatalogueIndexAction constructor.
     *
     * @param DefinitionRepository $definitionRepository
     * @param LocaleManager $localeManager
     */
    public function __construct(DefinitionRepository $definitionRepository, LocaleManager $localeManager)
    {
        $this->definitionRepository = $definitionRepository;
        $this->localeManager = $localeManager;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $queryBuilder = $this->definitionRepository->createQueryBuilder();
        $queryBuilder->from(Definition::class, 'd');
        $queryBuilder->select($queryBuilder->expr()->count('d.catalogue') . ' AS count');
        $queryBuilder->addSelect('d.catalogue');
        $queryBuilder->groupBy('d.catalogue');

        $catalogue = [];
        $result = $queryBuilder->getQuery()->getResult();
        foreach ($result as $item) {
            $count = (int)$item['count'];
            if (empty($count)) {
                continue;
            }

            $intl = [];
            foreach ($this->localeManager->all() as $localeItem) {
                $intl[$localeItem['locale']] = [
                    'locale' => $localeItem['locale'],
                    'country' => \mb_strtolower(\Locale::getRegion($localeItem['locale'])),
                    'count' => 0,
                ];
            }

            $queryBuilder = $this->definitionRepository->createQueryBuilder();
            $queryBuilder->from(Translation::class, 't');
            $queryBuilder->select($queryBuilder->expr()->count('t.id') . ' AS count', "t.locale");
            $queryBuilder->innerJoin(Definition::class, 'd', Join::WITH, 'd.id = t.definitionId');
            $queryBuilder->orWhere($queryBuilder->expr()->isNotNull("t.message"));
            $queryBuilder->orWhere($queryBuilder->expr()->neq("t.message", ":empty"));
            $queryBuilder->setParameter("empty", "");
            $queryBuilder->andWhere('d.catalogue = :catalogue');
            $queryBuilder->setParameter('catalogue', $item['catalogue']);
            $queryBuilder->addGroupBy("t.locale");

            $catalogueResult = $queryBuilder->getQuery()->getResult();
            foreach ($catalogueResult as $catalogueItem) {
                if (!\array_key_exists($catalogueItem['locale'], $intl)) {
                    continue;
                }

                $intl[$catalogueItem['locale']]['count'] = (int)$catalogueItem['count'];
            }

            $catalogue[] = [
                'catalogue' => $item['catalogue'],
                'count' => $count,
                'locales' => \array_values($intl),
            ];
        }

        return new ApiSuccessResponse($catalogue);
    }
}
