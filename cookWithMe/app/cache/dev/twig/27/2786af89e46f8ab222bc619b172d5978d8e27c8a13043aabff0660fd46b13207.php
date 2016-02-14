<?php

/* TwigBundle:Exception:exception_full.html.twig */
class __TwigTemplate_c24ed8ea70103192e3494aaad134de70321901915a05c533ffc98c702197a7dd extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("TwigBundle::layout.html.twig", "TwigBundle:Exception:exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "TwigBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_075bd735360cb7b9f2decbaa462cc4c537c350fa985df918149706d2bd7af18c = $this->env->getExtension("native_profiler");
        $__internal_075bd735360cb7b9f2decbaa462cc4c537c350fa985df918149706d2bd7af18c->enter($__internal_075bd735360cb7b9f2decbaa462cc4c537c350fa985df918149706d2bd7af18c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "TwigBundle:Exception:exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_075bd735360cb7b9f2decbaa462cc4c537c350fa985df918149706d2bd7af18c->leave($__internal_075bd735360cb7b9f2decbaa462cc4c537c350fa985df918149706d2bd7af18c_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_be2bfdbb3bfcf20e7b1446b4db556734f938bf0b0851c7da1dce5c75a3bdc1a6 = $this->env->getExtension("native_profiler");
        $__internal_be2bfdbb3bfcf20e7b1446b4db556734f938bf0b0851c7da1dce5c75a3bdc1a6->enter($__internal_be2bfdbb3bfcf20e7b1446b4db556734f938bf0b0851c7da1dce5c75a3bdc1a6_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_be2bfdbb3bfcf20e7b1446b4db556734f938bf0b0851c7da1dce5c75a3bdc1a6->leave($__internal_be2bfdbb3bfcf20e7b1446b4db556734f938bf0b0851c7da1dce5c75a3bdc1a6_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_8c41aca5093143d586c1b70e501a39edd118210f13d67f9dcc1c5ef571b97c84 = $this->env->getExtension("native_profiler");
        $__internal_8c41aca5093143d586c1b70e501a39edd118210f13d67f9dcc1c5ef571b97c84->enter($__internal_8c41aca5093143d586c1b70e501a39edd118210f13d67f9dcc1c5ef571b97c84_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_8c41aca5093143d586c1b70e501a39edd118210f13d67f9dcc1c5ef571b97c84->leave($__internal_8c41aca5093143d586c1b70e501a39edd118210f13d67f9dcc1c5ef571b97c84_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_e810811e01fecafec66891a61356e8fed858a3809375f905cca63429c504ccc7 = $this->env->getExtension("native_profiler");
        $__internal_e810811e01fecafec66891a61356e8fed858a3809375f905cca63429c504ccc7->enter($__internal_e810811e01fecafec66891a61356e8fed858a3809375f905cca63429c504ccc7_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("TwigBundle:Exception:exception.html.twig", "TwigBundle:Exception:exception_full.html.twig", 12)->display($context);
        
        $__internal_e810811e01fecafec66891a61356e8fed858a3809375f905cca63429c504ccc7->leave($__internal_e810811e01fecafec66891a61356e8fed858a3809375f905cca63429c504ccc7_prof);

    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends 'TwigBundle::layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include 'TwigBundle:Exception:exception.html.twig' %}*/
/* {% endblock %}*/
/* */
