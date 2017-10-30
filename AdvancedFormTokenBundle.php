<?php

namespace SecIT\AdvancedFormTokenBundle;

use SecIT\AdvancedFormTokenBundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AdvancedFormTokenBundle.
 *
 * @author Tomasz Gemza
 */
class AdvancedFormTokenBundle extends Bundle
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
