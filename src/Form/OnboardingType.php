<?php

namespace App\Form;

use App\DTO\Onboarding;
use App\ImmutableValue\Language;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OnboardingType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Onboarding::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('languages', EnumType::class, [
                'label' => 'Languages',
                'class' => Language::class,
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'grid grid-cols-3 gap-4 mt-3',
                ],
            ])
        ;
    }
}
