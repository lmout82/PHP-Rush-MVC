<?php

/* layout.html.twig */
class __TwigTemplate_a0e5a77f552f5f86340c4835a9352beabf9bf870fe94705eba3fc3fa87c42e71 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">
<html lang=\"en\">
  <head>
    <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <!--link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\"-->
    <!--script type=\"text/javascript\" src=\"script.js\"></script-->
  </head>
  <body>
\t\t
    ";
        // line 11
        $this->displayBlock('body', $context, $blocks);
        // line 13
        echo "
  </body>
</html>";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Titre";
    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        // line 12
        echo "    ";
    }

    public function getTemplateName()
    {
        return "layout.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  53 => 12,  50 => 11,  44 => 5,  38 => 13,  36 => 11,  27 => 5,  21 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "layout.html.twig", "/home/ludovic/Documents/www/PHP_Rush_MVC/Views/Layouts/layout.html.twig");
    }
}
