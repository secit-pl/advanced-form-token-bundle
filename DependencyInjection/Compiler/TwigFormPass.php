<?php

namespace SecIT\AdvancedFormTokenBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class TwigFormPass.
 *
 * @author Tomasz Gemza
 */
class TwigFormPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('twig.form.resources')) {
            return;
        }

        $container->setParameter('twig.form.resources', array_merge(
            ['AdvancedFormTokenBundle:form:fields.html.twig'],
            $container->getParameter('twig.form.resources')
        ));
    }
}
