<?php
/**
 * Created by Virgil
 * Date: 3/3/2016
 * Time: 5:35 AM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProgrammerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname','text')
            ->add('avatarNumber', 'choice', [
                'choices' => [
                    // the key is the value that will be set
                    // the value/label isn't shown in an API, and could
                    // be set to anything
                    1 => 'Girl (green)',
                    2 => 'Boy',
                    3 => 'Cat',
                    4 => 'Boy with Hat',
                    5 => 'Happy Robot',
                    6 => 'Girl (purple)',
                ]
            ])
            ->add('tagLine','textarea');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver ->setDefaults([
            'data_class' => 'AppBundle\Entity\Programmer',
        ]);
    }


    public function getName()
    {
        return 'programmer';
    }


}