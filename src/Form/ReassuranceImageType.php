<?php

namespace FOP\Doctrine\Form;

use FOP\Doctrine\Entity\DemoEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Capska\CapskaReassurance\Entity\ReassuranceImage;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * All Symfony 3.4 types are available in addition to the ones provided by PrestaShop.
 * Be careful, some of them are not *that* reliables, like IpAddressType.
 */
final class ReassuranceImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id_image', HiddenType::class)
            ->add('image_name', TextType::class)
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ReassuranceImage::class);
    }
}