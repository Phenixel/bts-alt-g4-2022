<?php

namespace App\Form;

use App\Entity\Prescrire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PrescrireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Med_depotlegal', TextType::class,[ 'label' => 'Médicament',])
            ->add('tin_code', TextType::class,[ 'label' => 'Type individu',])
            ->add('dos_code', TextType::class,[ 'label' => 'Dosage',])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prescrire::class,
        ]);
    }
}
