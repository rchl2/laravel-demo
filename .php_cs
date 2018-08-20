<?php

$excluded_directories = [
    'node_modules',
    'public',
    'resources/assets',
    'storage',
    'vendor'
];

$finder = PhpCsFixer\Finder::create()
    ->exclude($excluded_directories)
    ->notName('AcceptanceTester.php')
    ->notName('FunctionalTester.php')
    ->notName('UnitTester.php')
    ->in(__DIR__);
;

return PhpCsFixer\Config::create()
    ->setRules(array(
        '@Symfony' => true,
        '@PSR2' => true,
        'binary_operator_spaces' => ['align_double_arrow' => true],
        'array_syntax' => ['syntax' => 'short'],
        'not_operator_with_successor_space' => true,
        'ordered_imports' => ['sortAlgorithm' => 'length'],
    ))
    ->setFinder($finder)
;