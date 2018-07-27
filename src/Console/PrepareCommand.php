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
namespace KiwiSuite\Translation\Console;

use KiwiSuite\Contract\Command\CommandInterface;
use KiwiSuite\Entity\Entity\EntityCollection;
use KiwiSuite\Translation\Config\Config;
use KiwiSuite\Translation\Entity\Definition;
use KiwiSuite\Translation\Extractor\Collector;
use KiwiSuite\Translation\Repository\DefinitionRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PrepareCommand extends Command implements CommandInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var DefinitionRepository
     */
    private $definitionRepository;

    public function __construct(Config $config, DefinitionRepository $definitionRepository)
    {
        parent::__construct(self::getCommandName());
        $this->config = $config;
        $this->definitionRepository = $definitionRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!\file_exists($this->config->extractTarget())) {
            $output->writeln(\sprintf("File '%s' doesn't exists - nothing to do", $this->config->extractTarget()));
            return;
        }

        $collector = Collector::fromJson(\json_decode(\file_get_contents($this->config->extractTarget()), true));

        $definitionCollection = $this->definitionRepository->findAll();
        $definitionCollection = new EntityCollection($definitionCollection, function (Definition $definition) {
            return (string) $definition->id();
        });

        foreach ($collector as $catalogueData) {
            foreach ($catalogueData['translations'] as $translationData) {
                $checkCollection = $definitionCollection->filter(function (Definition $definition) use ($catalogueData, $translationData) {
                    return $definition->catalogue() === $catalogueData['name'] && $definition->name() === $translationData['name'];
                });

                if ($checkCollection->count() !== 1) {
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

                $definition = $checkCollection->first();

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

                $definitionCollection = $definitionCollection->filter(function (Definition $def) use ($definition) {
                    return $def->id() !== $definition->id();
                });
            }
        }

        foreach ($definitionCollection as $definition) {
            $output->writeln(\sprintf("Deleted definition for translation '%s'", $definition->id()));
            $this->definitionRepository->remove($definition);
        }
    }

    public static function getCommandName()
    {
        return 'translation:prepare';
    }
}
