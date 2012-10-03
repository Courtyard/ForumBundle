<?php

namespace Courtyard\Forum\Bundle\ForumBundle\Form\Type\Topic;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewTopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('postFirst', 'forum_post_first')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Courtyard\Forum\Bundle\ForumBundle\Entity\Topic'
        ));
    }

    public function getName()
    {
        return 'forum_topic';
    }
}