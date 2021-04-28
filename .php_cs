<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    'align_multiline_comment' => true,
    'ordered_imports' => ['sortAlgorithm' => 'alpha'],
    'array_indentation' => true,
    'binary_operator_spaces' => ['default' => 'single_space'],
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_statement' => ['statements' => ['return']],
    'cast_spaces' => true,
    'class_definition' => true,
    'clean_namespace' => true,
    'compact_nullable_typehint' => true,
    'concat_space' => ['spacing' => 'none'],
    'declare_equal_normalize' => true,
    // die_to_exit missing
    'elseif' => true,
    'encoding' => true,
    'full_opening_tag' => true,
    'function_declaration' => true,
    'function_typehint_space' => true,
    'hash_to_slash_comment' => true,  // deprecated
    'heredoc_to_nowdoc' => true,
    'include' => true,
    'indentation_type' => true,
    'lowercase_cast' => true,
    'lowercase_constants' => true,
    'lowercase_keywords' => true,
    'lowercase_static_reference' => true,
    'magic_constant_casing' => true,
    'magic_method_casing' => true,
    'method_argument_space' => true,
    'method_separation' => true,  // deprecated
    'visibility_required' => true,
    'native_function_casing' => true,
    'native_function_type_declaration_casing' => true,
    'no_alternative_syntax' => true,
    'no_binary_string' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    // no_blank_lines_after_throw, no_blank_lines_between_traits
    'no_extra_blank_lines' => [
        'tokens' => ['throw', 'use', 'useTrait', 'use_trait'],
    ],
    'single_line_after_imports' => true,
    'no_closing_tag' => true,
    'no_empty_phpdoc' => true,
    'no_empty_statement' => true,
    'no_extra_consecutive_blank_lines' => true,  // deprecated
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
    'no_short_bool_cast' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_after_function_name' => true,
    'no_spaces_around_offset' => true,  // Laravel specifies just inside_offset
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_comma_in_list_call' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_trailing_whitespace' => true,
    'no_trailing_whitespace_in_comment' => true,
    'no_unneeded_control_parentheses' => true,
    'no_unneeded_curly_braces' => true,
    'no_unset_cast' => true,
    'no_unused_imports' => true,
    'lambda_not_used_import' => true,
    'no_useless_return' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    'normalize_index_brace' => true,
    'not_operator_with_successor_space' => true,
    'object_operator_without_whitespace' => true,
    'phpdoc_indent' => true,
    'phpdoc_inline_tag' => true,
    'phpdoc_no_access' => true,
    'phpdoc_no_package' => true,
    'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_return_self_reference' => true,
    'phpdoc_scalar' => true,
    'phpdoc_single_line_var_spacing' => true,
    // phpdoc_singular_inheritdoc
    'phpdoc_summary' => true,
    'phpdoc_trim' => true,
    'phpdoc_no_alias_tag' => true,  // phpdoc_type_to_var
    'phpdoc_types' => true,
    'phpdoc_var_without_name' => true,
    'increment_style' => ['style' => 'post'],
    'no_mixed_echo_print' => ['use' => 'echo'],
    'visibility_required' => true,
    'braces' => true,
    'return_type_declaration' => true,
    'array_syntax' => ['syntax' => 'short'],
    'list_syntax' => ['syntax' => 'short'],
    'short_scalar_cast' => true,
    'single_blank_line_at_eof' => true,
    'single_blank_line_before_namespace' => true,
    'single_import_per_statement' => true,
    'single_line_after_imports' => true,
    'single_quote' => true,
    'space_after_semicolon' => true,
    'standardize_not_equals' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'switch_continue_to_break' => true,
    'ternary_operator_spaces' => true,
    'trailing_comma_in_multiline_array' => true,
    'trim_array_spaces' => true,
    // unalign_equals, align_equals is default false in `binary_operator_spaces` rule
    'unary_operator_spaces' => true,
    'line_ending' => true,  // enforcing LF not possible
    'whitespace_after_comma_in_array' => true,

    // risky
    'no_alias_functions' => true,
    'no_unreachable_default_argument_value' => true,
    'psr4' => true,  // deprecated
    'self_accessor' => true,
];

$finder = Finder::create()
    ->exclude('node_modules')
    ->exclude('nova/bootstrap/cache')
    ->exclude('nova/vendor')
    ->exclude('storage')
    ->exclude('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config)
    ->setRules($rules)
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setUsingCache(false);

// return PhpCsFixer\Config::create()
//     ->setFinder($finder)
//     ->setRules([
//         '@PSR2' => true,
//         'phpdoc_no_empty_return' => false,
//         'phpdoc_var_annotation_correct_order' => true,
//         'array_syntax' => [
//             'syntax' => 'short',
//         ],
//         'no_singleline_whitespace_before_semicolons' => true,
//         'no_extra_blank_lines' => [
//             'break', 'case', 'continue', 'curly_brace_block', 'default',
//             'extra', 'parenthesis_brace_block', 'return',
//             'square_brace_block', 'switch', 'throw', 'use', 'useTrait', 'use_trait',
//         ],
//         'cast_spaces' => [
//             'space' => 'single',
//         ],
//         'concat_space' => [
//             'spacing' => 'one',
//         ],
//         'ordered_imports' => [
//             'sort_algorithm' => 'alpha',
//         ],
//         'single_quote' => true,
//         'lowercase_cast' => true,
//         'lowercase_static_reference' => true,
//         'no_empty_phpdoc' => true,
//         'no_empty_comment' => true,
//         'array_indentation' => true,
//         // TODO: This isn't working, causes fixer to error.
//         // 'increment_style' => ['style' => 'post'],
//         'short_scalar_cast' => true,
//         'class_attributes_separation' => [
//             'elements' => ['const', 'method', 'property'],
//         ],
//         'no_mixed_echo_print' => [
//             'use' => 'echo',
//         ],
//         'no_unused_imports' => true,
//         'binary_operator_spaces' => [
//             'default' => 'single_space',
//         ],
//         'no_empty_statement' => true,
//         'unary_operator_spaces' => true, // $number ++ becomes $number++
//         'single_line_comment_style' => ['comment_types' => ['hash']], // # becomes //
//         'standardize_not_equals' => true, // <> becomes !=
//         'native_function_casing' => true,
//         'ternary_operator_spaces' => true,
//         'ternary_to_null_coalescing' => true,
//         'declare_equal_normalize' => [
//             'space' => 'single',
//         ],
//         'function_typehint_space' => true,
//         'no_leading_import_slash' => true,
//         'blank_line_before_statement' => [
//             'statements' => [
//                 'break', 'case', 'continue',
//                 'declare', 'default', 'die',
//                 'do', 'exit', 'for', 'foreach',
//                 'goto', 'if', 'include',
//                 'include_once', 'require', 'require_once',
//                 'return', 'switch', 'throw', 'try', 'while', 'yield',
//             ],
//         ],
//         'combine_consecutive_unsets' => true,
//         'method_chaining_indentation' => true,
//         'no_whitespace_in_blank_line' => true,
//         'blank_line_after_opening_tag' => true,
//         'no_trailing_comma_in_list_call' => true,
//         'list_syntax' => ['syntax' => 'short'],
//         // public function getTimezoneAttribute( ? Banana $value) becomes public function getTimezoneAttribute(?Banana $value)
//         'compact_nullable_typehint' => true,
//         'explicit_string_variable' => true,
//         'no_leading_namespace_whitespace' => true,
//         'trailing_comma_in_multiline_array' => true,
//         'not_operator_with_successor_space' => true,
//         'object_operator_without_whitespace' => true,
//         'single_blank_line_before_namespace' => true,
//         'no_blank_lines_after_class_opening' => true,
//         'no_blank_lines_after_phpdoc' => true,
//         'no_whitespace_before_comma_in_array' => true,
//         'no_trailing_comma_in_singleline_array' => true,
//         'multiline_whitespace_before_semicolons' => [
//             'strategy' => 'no_multi_line',
//         ],
//         'no_multiline_whitespace_around_double_arrow' => true,
//         'no_useless_return' => true,
//         'phpdoc_add_missing_param_annotation' => true,
//         'phpdoc_order' => true,
//         'phpdoc_scalar' => true,
//         'phpdoc_separation' => true,
//         'phpdoc_single_line_var_spacing' => true,
//         'single_trait_insert_per_statement' => true,
//         'ordered_class_elements' => [
//             'order' => [
//                 'use_trait',
//                 'constant',
//                 'property',
//                 'construct',
//                 'public',
//                 'protected',
//                 'private',
//             ],
//             'sortAlgorithm' => 'none',
//         ],
//         'return_type_declaration' => [
//             'space_before' => 'none',
//         ],
//     ])
//     ->setLineEnding("\n");
