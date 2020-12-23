<?php

declare(strict_types=1);

namespace Nawarian\PEG;

use Nawarian\PEG\Rule\Rule;
use Nawarian\PEG\Rule\RuleFactory;

final class Parser
{
    /**
     * @var array<string, Rule>
     */
    public $rules = [];

    public static function fromGrammar(string $grammar): self
    {
        $instance = new self();

        /**
         * @todo -> implement actual PEG parsing and fetch rules from $grammar
         */
        $instance->rules = [
            'PEG' => RuleFactory::sequence(
                RuleFactory::pattern('.*'),
                RuleFactory::pattern('!.'),
            ),
            'EndOfFile' => RuleFactory::pattern('!.'),
        ];

        return $instance;
    }
}
