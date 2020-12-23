<?php

declare(strict_types=1);

namespace Nawarian\PEG;

use Nawarian\PEG\Rule\Rule;
use Nawarian\PEG\Rule\RuleFactory;
use UnexpectedValueException;

final class Parser
{
    /**
     * @var array<string, Rule>
     */
    public $rules = [];

    public static function fromGrammar(string $grammar): self
    {
        $instance = new self();
        $instance->rules = $instance->createRulesFromGrammar($grammar);

        return $instance;
    }

    private function createRulesFromGrammar(string $grammar): array
    {
        $grammar = new Span($grammar);
        $rules = [];

        $ruleNameMatcher = RuleFactory::sequence(
            RuleFactory::pattern('[\w_]'),
            RuleFactory::pattern('[\w\d_]+'),
        );

        while (true) {
            $this->skipBlankSpaces($grammar);

            // Comment, let's just ignore it
            if ($grammar->current() === '#') {
                $grammar->readLine();
                continue;
            }

            if ($ruleName = $ruleNameMatcher->match($grammar->readUntilEOF(true))) {
                $grammar->read($ruleName->len);

                $this->skipBlankSpaces($grammar);

                $attributionSymbol = $grammar->read(2);
                if ($attributionSymbol !== '<-') {
                    throw new UnexpectedValueException(
                        sprintf(
                            "Expected a '<-' after rule name '%s', '%s' found.",
                            $ruleName->stream,
                            $attributionSymbol,
                        )
                    );
                }

                $this->skipBlankSpaces($grammar);

                $rule = $this->parseRule($grammar->current() . $grammar->readLine());

                $rules[$ruleName->stream] = $rule;
            }

            if ($grammar->peek() === null) {
                break;
            }
        }

        return $rules;
    }

    private function skipBlankSpaces(Span $grammar): void
    {
        $blankSpaceMatcher = RuleFactory::pattern('[\s\t\r]+');

        while ($blankSpaceMatcher->match($grammar->current())) {
            $grammar->next();
        }
    }

    private function parseRule(string $rawRule): Rule
    {
        $ruleNameMatcher = RuleFactory::sequence(
            RuleFactory::pattern('[\w_]'),
            RuleFactory::pattern('[\w\d_]+'),
        );

        $span = new Span($rawRule);
        $rules = [];

        while ($span->current()) {
            $not = false;

            if ($span->current() === '!') {
                $not = true;
                $span->next();
            }

            if ($span->current() === '.') {
                $modifier = $span->peek();
                $rule = RuleFactory::any();

                if ($modifier === '*') {
                    $span->next();
                    $this->skipBlankSpaces($span);
                    $rule = RuleFactory::zeroOrMany($rule);

                    $rules[] = $not ? RuleFactory::not($rule) : $rule;
                }

                if ((string) $modifier === '') {
                    $rules[] = $not ? RuleFactory::not($rule) : $rule;
                    $span->next();
                }
            }

            if (ctype_alpha($span->current()) || $span->current() === '_') {
                $ruleName = $ruleNameMatcher->match($span->readUntilEOF(true));
                $span = $span->subtract($ruleName);

                $rule = RuleFactory::named($ruleName->stream, $this);
                $rules[] = $not ? RuleFactory::not($rule) : $rule;
            }

            $span->next();
        }

        if (count($rules) === 0) {
            throw new UnexpectedValueException("Failed to read rule '{$rawRule}'.");
        }

        if (count($rules) === 1) {
            return current($rules);
        }

        return RuleFactory::sequence(...$rules);
    }
}
