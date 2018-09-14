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

/**
 * @param Twig_Environment $twig
 * @param $name
 * @throws Twig_Error_Syntax
 * @throws Twig_Error_Loader
 */
function compileTemplateSource(Twig_Environment $twig, $name)
{
    $source = $twig->getLoader()->getSourceContext($name);
    $content = $twig->compileSource($source);
    file_put_contents(__DIR__ . '/../output/' . $name . '.php', $content . PHP_EOL);
    file_put_contents(__DIR__ . '/../output/' . $name . '.php', '//# sourceMappingURL=' . $name . '.map', FILE_APPEND);
}

/**
 * @param Twig_Environment $twig
 * @param $name
 * @return void
 * @throws ReflectionException
 * @throws Twig_Error_Loader
 * @throws Twig_Error_Syntax
 */
function generateSourceMap(Twig_Environment $twig, $name)
{
    $template = $twig->createTemplate($name);
    $path = $template->getSourceContext()->getPath();
    $debug = $template->getDebugInfo();
    $output = (new \ReflectionClass($template))->getFileName();
    $map = \Kwf_SourceMaps_SourceMap::createEmptyMap($output);
    foreach ($debug as $outputLine => $sourceLine) {
        $map->addMapping($outputLine, 0, $sourceLine, 0, $path);
    }
    file_put_contents(__DIR__ . '/../output/' . $name . '.map', $map->getMapContents());
}
