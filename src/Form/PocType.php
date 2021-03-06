<?php

namespace App\Form;

use App\Entity\Poc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false
            ])
            ->add('githubLink')
            ->add('liveDemoLink')
            ->add('keywords')
            ->add('languages')
            ->add('categories')
            ->add('isPremium')
            ->add('price',MoneyType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Poc::class,
        ]);
    }
}
