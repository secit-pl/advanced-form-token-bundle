<?php

namespace SecIT\AdvancedFormTokenBundle\JavaScript;

use Tholu\Packer\Packer;

/**
 * Class TholuPhpPackerObfuscator
 *
 * @author Tomasz Gemza
 */
class TholuPhpPackerObfuscator implements ObfuscatorInterface
{
    protected $packerNotLoadedError = 'Class %s not found. Is tholu/php-packer installed?';

    /**
     * TholuPhpPackerObfuscator constructor.
     */
    public function __construct()
    {
        if (!class_exists(Packer::class)) {
            throw new \ErrorException(sprintf($this->packerNotLoadedError), Packer::class);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function obfuscate($content)
    {
        $encoding = array_rand(['Numeric', 'Normal', 'High ASCII']);
        $packer = new Packer($content, $encoding, true, false, true);

        return $packer->pack();
    }
}
