<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

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

$config = new Config();

return $config->setRules([
    '@PSR12' => true,
    'binary_operator_spaces' => true,
    'blank_line_before_statement' => [
        'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
    ],
    'declare_strict_types' => true,
    'method_chaining_indentation' => true,
    'no_unused_imports' => true,
    'not_operator_with_successor_space' => true,
    'ordered_imports' => [
        'imports_order' => ['class', 'function', 'const'],
        'sort_algorithm' => 'alpha',
    ],
    'ordered_traits' => true,
    'phpdoc_scalar' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_var_without_name' => true,
    'unary_operator_spaces' => true,
])
    ->setFinder($finder)
    ->setRiskyAllowed(true);
