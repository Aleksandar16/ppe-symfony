<?php

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        'array_syntax' => ['syntax' => 'short'],
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'heredoc_to_nowdoc' => true,
        'php_unit_strict' => false,
        'php_unit_construct' => true,
        'phpdoc_add_missing_param_annotation' => false,
        'phpdoc_order' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'no_extra_blank_lines' => ['tokens' => [
            'break', 'continue', 'extra', 'return', 'throw', 'use',
            'parenthesis_brace_block', 'square_brace_block', 'curly_brace_block',
        ]],
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'self_accessor' => false,
        'semicolon_after_instruction' => true,
        'combine_consecutive_unsets' => true,
        'concat_space' => ['spacing' => 'none'],
        'native_function_invocation' => false,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__.'/src')
    )
;
