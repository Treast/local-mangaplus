<?php

namespace App\Form;

use App\DTO\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Settings::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('androidId', TextType::class, [
                'label' => 'Android ID',
                'required' => false,
                'disabled' => true,
            ])
            ->add('deviceToken', TextType::class, [
                'label' => 'Device Token',
                'required' => false,
                'disabled' => true,
            ])
            ->add('securityKey', TextType::class, [
                'label' => 'Security Key',
                'required' => false,
                'disabled' => true,
            ])
            ->add('deviceSecret', TextType::class, [
                'label' => 'Device Secret',
                'required' => false,
                'disabled' => true,
            ])
            ->add('discordWebhook', TextType::class, [
                'label' => 'Discord Webhook URL',
                'required' => false,
                'attr' => [
                    'placeholder' => 'https://discordapp.com/api/webhooks/XXX/YYY',
                ],
            ])
        ;
    }
}
