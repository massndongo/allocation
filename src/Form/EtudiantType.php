<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Etudiant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule')
            ->add('prenom')
            ->add('nom')
            ->add('email')
            ->add('telephone')
            ->add('dateNaissance',DateType::class)
            ->add('typeEtudiant',ChoiceType::class,[
                'choices' => [
                    'type' => " ",
                    'Bousier' => "Boursier",
                    'Loger' => "Loger",
                    'Non Boursier' => "Non Boursier"
                ]
            ])
            ->add('chambre',EntityType::class,[
                'class' => Chambre::class,
                'choice_label' => 'numChambre',
                'attr' => [
                    'placeholder' => 'Numero Chambre'
                ]
            ])
            ->add('montant',ChoiceType::class,[
                'choices' => [
                    'Montant Bourse' => "Montant Bourse",
                    '20.000' => 20000,
                    '40.000' => 40000
                ]
            ])
            ->add('adresse')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
