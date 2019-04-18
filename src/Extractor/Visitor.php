<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Package\Translation\Extractor;

use Ixocreate\Package\Translation\Config\Config;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall as MethodCallNode;
use PhpParser\NodeVisitorAbstract;

final class Visitor extends NodeVisitorAbstract
{
    /**
     * @var Collector
     */
    private $collector;

    /**
     * @var string
     */
    private $file;

    /**
     * @var Config
     */
    private $config;

    /**
     * Visitor constructor.
     * @param Collector $collector
     * @param string $file
     * @param Config $config
     */
    public function __construct(Collector $collector, string $file, Config $config)
    {
        $this->collector = $collector;
        $this->file = $file;
        $this->config = $config;
    }

    /**
     * @param Node $node
     * @return int|Node|Node[]|null
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof MethodCallNode) {
            $this->handleTrans($node);
            $this->handleTransChoice($node);
        }
        return null;
    }

    /**
     * @param null|Node\Arg $arg
     * @return string
     */
    private function extractTranslation(?Node\Arg $arg = null): string
    {
        if (!$arg) {
            return '';
        }

        if (!($arg->value instanceof Node\Scalar\String_)) {
            return '';
        }

        return (string) $arg->value->value;
    }

    /**
     * @param null|Node\Arg $arg
     * @return string
     */
    private function extractCatalogue(?Node\Arg $arg = null): string
    {
        if (!$arg) {
            return $this->config->defaultCatalogue();
        }

        if (!($arg->value instanceof Node\Scalar\String_)) {
            return $this->config->defaultCatalogue();
        }

        return (string) $arg->value->value;
    }

    /**
     * @param null|Node\Arg $arg
     * @return array
     */
    private function extractParameters(?Node\Arg $arg = null): array
    {
        if (!$arg) {
            return [];
        }

        if (!($arg->value instanceof Node\Expr\Array_)) {
            return [];
        }

        $parameters = [];

        /** @var Node\Expr\ArrayItem $item */
        foreach ($arg->value->items as $item) {
            $parameters[] = $item->key->value;
        }

        return $parameters;
    }

    /**
     * @param Node $node
     */
    private function handleTrans(MethodCallNode $node)
    {
        if (!($node->name instanceof Node\Identifier) || $node->name->name !== 'trans') {
            return;
        }

        $translation = $this->extractTranslation((!empty($node->args[0])) ? $node->args[0] : null);
        if (empty($translation)) {
            return;
        }

        $parameters = $this->extractParameters((!empty($node->args[1])) ? $node->args[1] : null);
        $catalogue = $this->extractCatalogue((!empty($node->args[2])) ? $node->args[2] : null);

        $this->collector->add($translation, $this->file, $parameters, $catalogue);
    }

    /**
     * @param Node $node
     */
    private function handleTransChoice(MethodCallNode $node)
    {
        if (!($node->name instanceof Node\Identifier) || $node->name->name !== 'transPlural') {
            return;
        }

        $translation = $this->extractTranslation((!empty($node->args[0])) ? $node->args[0] : null);
        if (empty($translation)) {
            return;
        }

        $parameters = $this->extractParameters((!empty($node->args[2])) ? $node->args[2] : null);
        $catalogue = $this->extractCatalogue((!empty($node->args[3])) ? $node->args[3] : null);

        $this->collector->add($translation, $this->file, $parameters, $catalogue);
    }
}
