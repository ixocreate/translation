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
use KiwiSuite\Translation\Config\Config;
use KiwiSuite\Translation\Extractor\Extractor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ExtractCommand extends Command implements CommandInterface
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
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
    }

    public static function getCommandName()
    {
        return 'translation:extract';
    }
}
