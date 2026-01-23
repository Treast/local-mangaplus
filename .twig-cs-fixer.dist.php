<?php

use TwigCsFixer\Config\Config;
use TwigCsFixer\File\Finder;
use TwigCsFixer\Rules\File\FileExtensionRule;
use TwigCsFixer\Ruleset\Ruleset;

$ruleset = new Ruleset()
    ->addStandard(new TwigCsFixer\Standard\TwigCsFixer())
    ->addRule(new FileExtensionRule())
;

$finder = new Finder();
$finder->in('templates');

$config = new Config()
    ->setRuleset($ruleset)
    ->setFinder($finder)
;

return $config;
