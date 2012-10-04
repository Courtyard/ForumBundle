<?php

namespace Courtyard\Bundle\ForumBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;

class EntityConverter implements ParamConverterInterface
{
    protected $classes;
    
    public function __construct($boardClass, $topicClass, $postClass)
    {
        $this->classes = array(
            'Courtyard\Forum\Entity\BoardInterface' => $boardClass,
            'Courtyard\Forum\Entity\TopicInterface' => $topicClass,
            'Courtyard\Forum\Entity\PostInterface' => $postClass
        );
    }
    
    /**
     * Convert our interface hints into DoctrineParamConverter compatible hints
     * 
     * {@inheritDoc}
     */
    public function apply(Request $request, ConfigurationInterface $configuration)
    {
        $configuration->setClass($this->classes[$configuration->getClass()]);
    }
    
    /**
     * {@inheritDoc}
     */
    public function supports(ConfigurationInterface $configuration)
    {
        return isset($this->classes[$configuration->getClass()]);
    }
}