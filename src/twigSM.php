#!/usr/bin/env php
<?php
// Specify our Twig templates location
use GetOpt\GetOpt;

require __DIR__ . '/twig_source_map_utils.php';
require_once __DIR__ . '/../vendor/autoload.php';

$optionOutputPath = new \GetOpt\Option('o', 'output', \GetOpt\GetOpt::REQUIRED_ARGUMENT);
$optionOutputPath->setDescription('Provide path to output dir');

$optionTemplatePath = new \GetOpt\Option('t', 'template', \GetOpt\GetOpt::REQUIRED_ARGUMENT);
$optionTemplatePath->setDescription('Provide template name');

$getopt = new GetOpt();
$getopt->addOptions([$optionOutputPath, $optionTemplatePath]);

$getopt->process();

$output = $getopt->getOption('output');
$template = $getopt->getOption('template');

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');

// Instantiate our Twig
$twig = new Twig_Environment($loader);
// provide some options to debug
$twig->enableDebug();
$twig->enableAutoReload();

if (isTwigTemplateName($template)) {
    try {
        compileTemplateSource($twig, $template, $output);
        generateSourceMap($twig, $template, $output);
    } catch (Twig_Error_Syntax $e) {
    } catch (ReflectionException $e) {
    } catch (Twig_Error_Loader $e) {
    }
}
