<?php
/**
 * Created by PhpStorm.
 * User: ruich
 * Date: 14/01/2019
 * Time: 23:14
 */

namespace App\Controller;


class ProfileUserType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('birthday',BirthdayType::class)
            ->add('submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}