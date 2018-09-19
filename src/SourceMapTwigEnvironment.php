<?php


/**
 * Extends Twig_Environment with the possibility to generate source maps in order to debug templates
 */
class SourceMapTwigEnvironment extends \Twig_Environment
{
    private $outputPath;

    public function __construct(Twig_LoaderInterface $loader, array $options = array())
    {
        parent::__construct($loader, $options);
        $this->enableDebug();
        $this->enableAutoReload();
        $this->setCache(__DIR__ . '/../cache');
    }

    public function loadTemplate($name, $index = null)
    {
        $template = parent::loadTemplate($name, $index);
        try {
            $this->generateSourceMap($name, $template, $this->outputPath);
        } catch (ReflectionException $e) {
        }
    }

    /**
     * @param $name
     * @param $template
     * @param $outputPath
     * @throws ReflectionException
     */
    public function generateSourceMap($name, Twig_Template $template, $outputPath)
    {
        $path = $template->getSourceContext()->getPath();
        $debug = $template->getDebugInfo();
        $output = (new \ReflectionClass($template))->getFileName();
        $map = \Kwf_SourceMaps_SourceMap::createEmptyMap($output);
        foreach ($debug as $outputLine => $sourceLine) {
            $map->addMapping($outputLine, 0, $sourceLine, 0, $path);
        }
        echo "\n" . $outputPath . '/' . $name . '.map';
        file_put_contents($outputPath . '/' . $name . '.map', $map->getMapContents());
    }

    /**
     * @param mixed $outputPath
     */
    public function setOutputPath($outputPath)
    {
        $this->outputPath = $outputPath;
    }
}