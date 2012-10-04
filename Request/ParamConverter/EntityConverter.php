<?php

namespace Courtyard\Bundle\ForumBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;

class EntityConverter implements ParamConverterInterface
{
    protected $classes;
    
    public function __construct(array $classes = array())
    {
        $this->classes = $classes ?: array(
            'Courtyard\Forum\Entity\BoardInterface' => 'Courtyard\Bundle\ForumBundle\Entity\Board',
            'Courtyard\Forum\Entity\TopicInterface' => 'Courtyard\Bundle\ForumBundle\Entity\Topic',
            'Courtyard\Forum\Entity\PostInterface' => 'Courtyard\Bundle\ForumBundle\Entity\Post'
        );
    }
    
    public function apply(Request $request, ConfigurationInterface $configuration)
    {
        $configuration->setClass($this->classes[$configuration->getClass()]);
    }
    
    public function supports(ConfigurationInterface $configuration)
    {
        return isset($this->classes[$configuration->getClass()]);
    }
}