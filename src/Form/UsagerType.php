<?php

namespace App\Form;

use App\Entity\Usager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;

class UsagerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('nom')
            ->add('prenom')
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'loginCaptcha',
                'label' => "Entrez les caractères que vous voyez sur l'image ci dessous :"
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usager::class,
        ]);
    }
}
