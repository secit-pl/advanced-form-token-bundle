<?php

namespace SecIT\JavascriptFormCsrfProtectionBundle;

use SecIT\JavascriptFormCsrfProtectionBundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class JavascriptFormCsrfProtectionBundle.
 *
 * @author Tomasz Gemza
 */
class JavascriptFormCsrfProtectionBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new TwigFormPass());
    }
}
