<?php

namespace SecIT\AdvancedFormTokenBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Class JavascriptCsrfTokenType.
 *
 * @author Tomasz Gemza
 */
class JavascriptCsrfTokenType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return HiddenType::class;
    }
}
