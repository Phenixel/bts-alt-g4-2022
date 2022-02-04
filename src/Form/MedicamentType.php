<?php

namespace App\Form;

use App\Entity\Medicament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class MedicamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('MED_NOMCOMMERCIAL', TextType::class,[
                'label' => 'Nom',
            ])
            ->add('FAM_CODE', TextType::class,[
                'label' => 'Nom famille',
            ])
            ->add('MED_COMPOSITION', TextType::class,[
                'label' => 'Composition',
            ])
            ->add('MED_EFFETS', TextType::class,[
                'label' => 'Effets',
            ])
            ->add('MED_CONTREINDIC', TextType::class,[
                'label' => 'Contre indications',
            ])
            ->add('MED_PRIXECHANTILLON', TextType::class,[
                'label' => 'Prix',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medicament::class,
        ]);
    }
}
