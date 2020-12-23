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

    public function parse(string $text, string $rootRule): Token
    {
        $rule = $this->rules[$rootRule];

        $result = $rule->match($text);

        return new Token($rootRule, $result);
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

            if ($span->current() === '[') {
                $span->next();
                $pattern = '';

                while ($span->current() !== ']') {
                    $pattern .= $span->current();
                    $span->next();
                }

                $rule = RuleFactory::pattern("[{$pattern}]");
                $rules[] = $not ? RuleFactory::not($rule) : $rule;
                $span->next();
            }

            if ($span->current() === '"' || $span->current() === "'") {
                $delimiter = $span->current();
                $span->next();
                $literal = '';

                while ($span->current() !== $delimiter) {
                    $literal .= $span->current();
                    $span->next();
                }
                $span->next();

                $rule = RuleFactory::literal($literal);
                $rules[] = $not ? RuleFactory::not($rule) : $rule;
            }

            if (ctype_alpha($span->current()) || $span->current() === '_') {
                $ruleName = $ruleNameMatcher->match($span->readUntilEOF(true));
                $span->read($ruleName->len);

                $rule = RuleFactory::named($ruleName->stream, $this);
                $rule = $not ? RuleFactory::not($rule) : $rule;

                if ($span->current() === '+') {
                    $rule = RuleFactory::oneOrMany($rule);
                    $span->next();
                } elseif ($span->current() === '*') {
                    $rule = RuleFactory::zeroOrMany($rule);
                    $span->next();
                }

                $rules[] = $rule;
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
