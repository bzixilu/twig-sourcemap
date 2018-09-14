<?php

/* MyBuilder.php.twig */
class __TwigTemplate_b4751531ddd5ce6233f202dda64f894dcefc687e976fbb2ee82d00d5b0729131 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("_base/common.php.twig", "MyBuilder.php.twig", 1);
        $this->blocks = array(
            'functions' => array($this, 'block_functions'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "_base/common.php.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_functions($context, array $blocks = array())
    {
        // line 4
        echo "    public function tellMeHello()
    {
    echo \"Hello world\";
    }
";
    }

    public function getTemplateName()
    {
        return "MyBuilder.php.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 4,  32 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"_base/common.php.twig\" %}

{% block functions %}
    public function tellMeHello()
    {
    echo \"Hello world\";
    }
{% endblock %}", "MyBuilder.php.twig", "/home/user/PhpstormProjects/twig_source_map/templates/MyBuilder.php.twig");
    }
}

//# sourceMappingURL=MyBuilder.php.twig.map