<?php


function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function isTwigTemplateName($name)
{
    return endsWith($name, 'twig');
}

/**
 * @param Twig_Environment $twig
 * @param $name - template name
 * @param $output - output dir
 * @throws Twig_Error_Loader
 * @throws Twig_Error_Syntax
 */
function compileTemplateSource(Twig_Environment $twig, $name, $output)
{
    $source = $twig->getLoader()->getSourceContext($name);
    $content = $twig->compileSource($source);
    file_put_contents($output . '/' . $name . '.php', $content . PHP_EOL);
    file_put_contents($output . '/' . $name . '.php', '//# sourceMappingURL=' . $name . '.map', FILE_APPEND);
}

/**
 * @param Twig_Environment $twig
 * @param $name - name of template
 * @param $outputPath - path to output dir
 * @return void
 * @throws ReflectionException
 * @throws Twig_Error_Loader
 * @throws Twig_Error_Syntax
 */
function generateSourceMap(Twig_Environment $twig, $name, $outputPath)
{
    $template = $twig->createTemplate($name);
    $path = $template->getSourceContext()->getPath();
    $debug = $template->getDebugInfo();
    $output = (new \ReflectionClass($template))->getFileName();
    $map = \Kwf_SourceMaps_SourceMap::createEmptyMap($output);
    foreach ($debug as $outputLine => $sourceLine) {
        $map->addMapping($outputLine, 0, $sourceLine, 0, $path);
    }
    file_put_contents($outputPath . '/' . $name . '.map', $map->getMapContents());
}