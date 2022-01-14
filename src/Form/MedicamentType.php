<?php

namespace App\Form;

use App\Entity\Medicament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('MED_NOMCOMMERCIAL')
            ->add('FAM_CODE')
            ->add('MED_COMPOSITION')
            ->add('MED_EFFETS')
            ->add('MED_CONTREINDIC')
            ->add('MED_PRIXECHANTILLON')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medicament::class,
        ]);
    }
}
