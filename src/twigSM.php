#!/usr/bin/env php
<?php
// Specify our Twig templates location
require __DIR__ . '/twig_source_map_utils.php';
require_once __DIR__ . '/../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');

// Instantiate our Twig
$twig = new Twig_Environment($loader);
// provide some options to debug
$twig->enableDebug();
$twig->enableAutoReload();

foreach ($argv as $value) {
    if (isTwigTemplateName($value)) {
        try {
            compileTemplateSource($twig, $value);
            generateSourceMap($twig, $value);
        } catch (Twig_Error_Syntax $e) {
        } catch (ReflectionException $e) {
        } catch (Twig_Error_Loader $e) {
        }
    }
}
