# Advanced Symfony Form Token

This bundle provides the advanced form token implementation for Symfony 2.8 and 3.0+.

## Features

- JavaScript version of the core form token
- JavaScript code obfuscation (requires external libraries)

## Installation

From the command line run

```
$ composer require secit-pl/advanced-form-token
```

Update your AppKernel by adding the bundle declaration

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            ...
            new SecIT\AdvancedFormTokenBundle\AdvancedFormTokenBundle(),
        ];

        ...
    }
}
```

## Usage

By default this bundle is disabled for all forms. You can enable it globally or for a single form.

#### Simgle form usage

To enable the JavaScript token just add the `javascript_csrf_protection` to the form defaults.

```php
<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as FormField;
use Symfony\Component\Validator\Constraints;

class ContactType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'javascript_csrf_protection' => true, // enable the JavaScript form token
            
            ...
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        ...
    }
}

```

Here is the list of possible options used by JavaScript form token. Most of them works the same like the native Symfony form token options. 

**javascript_csrf_protection** - default: false - is JavaScript form token enabled?
 
**javascript_csrf_field_name** - deafult: _jstoken - the token form field name

**javascript_csrf_message** - The error message displayed if the form token is invalid

**javascript_csrf_javascript_obfuscator'** - deafult: null - The obfuscator class used to obfuscate generated token JavaScript code

#### Global configuration

config.yml

```yaml
advanced_form_token:
    javascript_token:
        enabled: ~ # default false - is JavaScript form token enabled for all forms?
        field_name: ~ # deafult: _jstoken - the token form field name for all forms
        javascript_obfuscator: ~ # deafult: null - The obfuscator class used to obfuscate generated token JavaScript code for all forms
```

#### JavaScript obfuscator

By default generated JavaScript code is not obfuscated. To enable it you need to define the obfuscator class which should
be used for this operation. This class should implements the `SecIT\AdvancedFormTokenBundle\JavaScript\ObfuscatorInterface`.

Current version provides one ready to use obfuscator `SecIT\AdvancedFormTokenBundle\JavaScript\TholuPhpPackerObfuscator` which
requires that you have already installed the https://github.com/tholu/php-packer. This package in not installed by default
due to the fact that it uses the LGPL-2.1 license thich is not fully compatible with MIT license used by this bundle.

To enable the obfuscator for a single form set the `javascript_csrf_javascript_obfuscator` option to the `SecIT\AdvancedFormTokenBundle\JavaScript\TholuPhpPackerObfuscator` value.
 
In most cases you'd like to have obfuscator enabled for all JavaScript token forms so the best way will be to set it up
globally in your `config.yml`:

```yaml
advanced_form_token:
    javascript_token:
        javascript_obfuscator: SecIT\AdvancedFormTokenBundle\JavaScript\TholuPhpPackerObfuscator
```

From now TholuPhpPackerObfuscator will randomly obfuscate the JavaScript code generated for each form token.