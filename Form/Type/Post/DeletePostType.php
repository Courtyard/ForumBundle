<?php

namespace Courtyard\Bundle\ForumBundle\Form\Type\Post;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeletePostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Courtyard\Bundle\ForumBundle\Entity\Post'
        ));
    }

    public function getName()
    {
        return 'forum_post_delete';
    }
}