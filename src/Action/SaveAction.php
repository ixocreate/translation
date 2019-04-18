<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Package\Action;

use Ixocreate\Admin\Package\Response\ApiSuccessResponse;
use Ixocreate\Intl\Package\LocaleManager;
use Ixocreate\Translation\Package\Entity\Translation;
use Ixocreate\Translation\Package\Repository\DefinitionRepository;
use Ixocreate\Translation\Package\Repository\TranslationRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

final class SaveAction implements MiddlewareInterface
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
        $data = $request->getParsedBody();

        $message = (string) $data['message'];

        if (!empty($data['id'])) {
            /** @var Translation $translation */
            $translation = $this->translationRepository->find($data['id']);
            if (empty($translation)) {
                return $handler->handle($request);
            }


            $translation = $translation->with("message", $message);
            $this->translationRepository->save($translation);

            return new ApiSuccessResponse();
        }

        $translation = $this->translationRepository->findOneBy([
            'locale' => $data['locale'],
            'definitionId' => $data['definitionId'],
        ]);

        if (empty($translation)) {
            $translation = new Translation([
                'id' => Uuid::uuid4()->toString(),
                'definitionId' => $data['definitionId'],
                'locale' => $data['locale'],
            ]);
        }

        $translation = $translation->with('message', $message);
        $this->translationRepository->save($translation);

        return new ApiSuccessResponse();
    }
}
