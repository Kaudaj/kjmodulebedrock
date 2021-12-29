<?php
$rootDir = __DIR__ . '/../../';

$finder = PhpCsFixer\Finder::create()
    ->in($rootDir)
    ->exclude(['vendor', 'node_modules'])
;

$config = new PrestaShop\CodingStandards\CsFixer\Config();
return $config
    ->setUsingCache(true)
    ->setCacheFile(__DIR__.'/.php-cs-fixer.cache')
    ->setFinder($finder)
;
