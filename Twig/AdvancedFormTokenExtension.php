<?php

namespace SecIT\AdvancedFormTokenBundle\Twig;
use SecIT\AdvancedFormTokenBundle\JavaScript\ObfuscatorInterface;

/**
 * Class AdvancedFormTokenExtension.
 *
 * @author Tomasz Gemza
 */
class AdvancedFormTokenExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('advanced_form_token_javascript_obfuscator', [$this, 'javaScriptObfuscatorFilter'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'advanced_form_token_extension';
    }

    /**
     * Obfuscate given JavaScript content.
     *
     * @param string $content
     * @param string $obfuscatorClass
     *
     * @return string
     */
    public function javaScriptObfuscatorFilter($content, $obfuscatorClass)
    {
        $obfuscator = $this->getObfuscator($obfuscatorClass);
        if (!$obfuscator) {
            return $content;
        }

        return $obfuscator->obfuscate($content);
    }

    /**
     * Get JavaScript obfuscator.
     *
     * @param string $obfuscatorClass
     *
     * @return null|ObfuscatorInterface
     */
    protected function getObfuscator($obfuscatorClass)
    {
        if (!$obfuscatorClass) {
            return null;
        }

        return new $obfuscatorClass;
    }
}
