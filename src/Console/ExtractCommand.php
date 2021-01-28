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
use Ixocreate\Translation\Extractor\Extractor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ExtractCommand extends Command implements CommandInterface
{
    /**
     * @var TranslationConfig
     */
    private $config;

    public function __construct(TranslationConfig $config)
    {
        parent::__construct(self::getCommandName());
        $this->config = $config;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $phpExtractor = new Extractor();
        $collector = $phpExtractor->extract($this->config, $this->config->extractDirectories());

        if (!\is_dir($this->config->extractTarget())) {
            $dir = \dirname($this->config->extractTarget());
            if (!\is_dir($dir)) {
                \mkdir($dir, 0777, true);
            }
        }

        \file_put_contents($this->config->extractTarget(), \json_encode($collector), LOCK_EX);

        return 0;
    }

    public static function getCommandName()
    {
        return 'translation:extract';
    }
}
