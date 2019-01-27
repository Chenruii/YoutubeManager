<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Video;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('createdAt')
            ->add('published')
            ->add('url')
            ->add('description')
            ->add('Category',EntityType::class, [
                'class' =>Video::class,
                'choice_label' =>'category',
            ])
            ->add('user', EntityType::class, [
                'class'  => User::class,
                'choice label'  => 'firsname',
            ])
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
