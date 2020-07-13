<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Batiment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numChambre', TextType::class,[
                'attr' => [
                    'placeholder' => "Numero Chambre",
                    'disabled' => true
                ],
                'label' => " "
            ])
            ->add('numBatiment',EntityType::class,[
                'class' => Batiment::class,
                'choice_label' => 'numBatiment',
                'label' => "Numéro Batiment"
            ])
            ->add('typeChambre', ChoiceType::class,[
                'choices' => [
                    'Individuel' => "Individuel",
                    'A Deux' => "A Deux",
                ],
                'label' => "Type de Chambre"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}
