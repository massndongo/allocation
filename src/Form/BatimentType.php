<?php

namespace App\Form;

use App\Entity\Batiment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BatimentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('numBatiment', NumberType::class,[
            'attr' => [
                'placeholder' => "Numéro Batiment",
            ],
            'label' => " "
        ])
        ->add('libelle', TextType::class,[
            'attr' => [
                'placeholder' => "Libelle",
            ],
            'label' => " "
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Batiment::class,
        ]);
    }
}
