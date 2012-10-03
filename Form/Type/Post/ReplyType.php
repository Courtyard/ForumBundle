<?php

namespace Courtyard\Forum\Bundle\ForumBundle\Form\Type\Post;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('message')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Courtyard\Forum\Bundle\ForumBundle\Entity\Post'
        ));
    }

    public function getName()
    {
        return 'forum_post';
    }
}