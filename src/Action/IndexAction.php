<?php
namespace KiwiSuite\Translation\Action;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\Expr\Join;
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
        $criteria = new Criteria();
        $criteria->orderBy(['name' => 'ASC']);
        $criteria->andWhere(Criteria::expr()->eq('catalogue', $request->getAttribute('catalogue')));

        if (!empty($request->getQueryParams()['search']) && is_string($request->getQueryParams()['search'])) {
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
                    'country' => strtolower(\Locale::getRegion($localeItem['locale'])),
                    'translated' => false,
                ];
            }

            $data[(string) $definition->id()] = [
                'id' => $definition->id(),
                'name' => $definition->name(),
                'locales' => $intl,
            ];
        }

        $result = $this->translationRepository->findBy(['definitionId' => array_keys($data)]);
        /** @var Translation $translation */
        foreach ($result as $translation) {
            if (!array_key_exists((string) $translation->definitionId(), $data)) {
                continue;
            }

            if (!array_key_exists((string) $translation->locale(), $data[(string) $translation->definitionId()]['locales'])) {
                continue;
            }

            $data[(string) $translation->definitionId()]['locales'][$translation->locale()]['translated'] = (!empty($translation->message()));
        }


        foreach ($data as $key => $item) {
            $data[$key]['locales'] = array_values($data[$key]['locales']);
        }

        return new ApiSuccessResponse(array_values($data));
    }
}