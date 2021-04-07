<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Translation\Console;

use Ixocreate\Application\Console\CommandInterface;
use Ixocreate\Translation\Config\TranslationConfig;
use Ixocreate\Translation\Entity\Definition;
use Ixocreate\Translation\Extractor\Collector;
use Ixocreate\Translation\Repository\DefinitionRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PrepareCommand extends Command implements CommandInterface
{
    /**
     * @var TranslationConfig
     */
    private $config;

    /**
     * @var DefinitionRepository
     */
    private $definitionRepository;

    public function __construct(TranslationConfig $config, DefinitionRepository $definitionRepository)
    {
        parent::__construct(self::getCommandName());
        $this->setDescription('update translation tables from extracted definition');
        $this->config = $config;
        $this->definitionRepository = $definitionRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!\file_exists($this->config->extractTarget())) {
            $output->writeln(\sprintf("File '%s' doesn't exists - nothing to do", $this->config->extractTarget()));
            return 1;
        }

        $collector = Collector::fromJson(\json_decode(\file_get_contents($this->config->extractTarget()), true));

        $knownDefinitions = [];
        foreach ($this->definitionRepository->findAll() as $definition) {
            /** @var Definition $definition */
            $knownDefinitions[$definition->catalogue()][$definition->name()] = $definition;
        }

        foreach ($collector as $catalogueData) {
            foreach ($catalogueData['translations'] as $translationData) {
                $definition = $knownDefinitions[$catalogueData['name']][$translationData['name']] ?? null;

                if ($definition === null) {
                    $definition = new Definition([
                        'id' => Uuid::uuid4()->toString(),
                        'name' => $translationData['name'],
                        'catalogue' => $catalogueData['name'],
                        'files' => $translationData['files'],
                        'placeholders' => $translationData['placeholders'],
                    ]);

                    $this->definitionRepository->save($definition);
                    $output->writeln(\sprintf("Insert definition for translation '%s'", $translationData['name']));
                    continue;
                }

                $update = false;

                if ($definition->files() !== $translationData['files']) {
                    $update = true;
                    $definition = $definition->with('files', $translationData['files']);
                }

                if ($definition->files() !== $translationData['placeholders']) {
                    $update = true;
                    $definition = $definition->with('placeholders', $translationData['placeholders']);
                }

                if ($update === true) {
                    $this->definitionRepository->save($definition);
                    $output->writeln(\sprintf("Updated definition for translation '%s'", $translationData['name']));
                }

                unset($knownDefinitions[$catalogueData['name']][$translationData['name']]);
            }
        }

        foreach ($knownDefinitions as $catalogue) {
            foreach ($catalogue as $definition) {
                $output->writeln(\sprintf("Deleted definition for translation '%s'", $definition->id()));
                $this->definitionRepository->remove($definition);
            }
        }

        return 0;
    }

    public static function getCommandName()
    {
        return 'translation:prepare';
    }
}
