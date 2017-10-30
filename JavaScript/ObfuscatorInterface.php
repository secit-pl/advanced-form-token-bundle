<?php

namespace SecIT\AdvancedFormTokenBundle\JavaScript;

/**
 * Interface ObfuscatorInterface.
 *
 * @author Tomasz Gemza
 */
interface ObfuscatorInterface
{
    /**
     * Returns obfuscated javascript content.
     *
     * @param string $content
     *
     * @return string
     */
    public function obfuscate($content);
}
