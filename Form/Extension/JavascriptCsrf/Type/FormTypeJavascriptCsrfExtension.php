<?php

namespace SecIT\AdvancedFormTokenBundle\Form\Extension\JavascriptCsrf\Type;

use SecIT\AdvancedFormTokenBundle\Form\Type\JavascriptCsrfTokenType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Csrf\EventListener\CsrfValidationListener;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Util\ServerParams;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class FormTypeJavascriptCsrfExtension
 *
 * This class is based on the Symfony\Component\Form\Extension\Csrf\Type\FormTypeCsrfExtension
 * created by Bernhard Schussek. Base file was taken from the Symfony in version 3.3.10.
 *
 * @author Tomasz Gemza
 */
class FormTypeJavascriptCsrfExtension extends AbstractTypeExtension
{
    /**
     * @var CsrfTokenManagerInterface
     */
    private $defaultTokenManager;

    /**
     * @var bool
     */
    private $defaultEnabled;

    /**
     * @var string
     */
    private $defaultFieldName;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var null|string
     */
    private $translationDomain;

    /**
     * @var ServerParams
     */
    private $serverParams;

    /**
     * FormTypeJavascriptCsrfExtension constructor.
     *
     * @param CsrfTokenManagerInterface $defaultTokenManager
     * @param bool                      $defaultEnabled
     * @param string                    $defaultFieldName
     * @param TranslatorInterface|null  $translator
     * @param null                      $translationDomain
     * @param ServerParams|null         $serverParams
     */
    public function __construct(
        CsrfTokenManagerInterface $defaultTokenManager,
        $defaultEnabled = false,
        $defaultFieldName = '_jstoken',
        TranslatorInterface $translator = null,
        $translationDomain = null, ServerParams
        $serverParams = null
    ) {
        $this->defaultTokenManager = $defaultTokenManager;
        $this->defaultEnabled = $defaultEnabled;
        $this->defaultFieldName = $defaultFieldName;
        $this->translator = $translator;
        $this->translationDomain = $translationDomain;
        $this->serverParams = $serverParams;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$options['javascript_csrf_protection']) {
            return;
        }

        $builder
            ->addEventSubscriber(new CsrfValidationListener(
                $options['javascript_csrf_field_name'],
                $options['javascript_csrf_token_manager'],
                $options['javascript_csrf_token_id'] ?: ($builder->getName() ?: get_class($builder->getType()->getInnerType())),
                $options['javascript_csrf_message'],
                $this->translator,
                $this->translationDomain,
                $this->serverParams
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($options['javascript_csrf_protection'] && !$view->parent && $options['compound']) {
            $factory = $form->getConfig()->getFormFactory();
            $tokenId = $options['javascript_csrf_token_id'] ?: ($form->getName() ?: get_class($form->getConfig()->getType()->getInnerType()));
            $data = (string) $options['javascript_csrf_token_manager']->getToken($tokenId);

            $csrfForm = $factory->createNamed($options['javascript_csrf_field_name'], JavascriptCsrfTokenType::class, $data, [
                'mapped' => false,
            ]);

            $view->children[$options['javascript_csrf_field_name']] = $csrfForm->createView($view);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'javascript_csrf_protection' => $this->defaultEnabled,
            'javascript_csrf_field_name' => $this->defaultFieldName,
            'javascript_csrf_message' => 'The JSCSRF token is invalid. Please try to resubmit the form.',
            'javascript_csrf_token_manager' => $this->defaultTokenManager,
            'javascript_csrf_token_id' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return FormType::class;
    }
}
