<?php

namespace Courtyard\Bundle\ForumBundle\Twig\Extension;

use Courtyard\Forum\Entity\BoardInterface;
use Courtyard\Forum\Entity\TopicInterface;
use Courtyard\Forum\Entity\PostInterface;
use Courtyard\Bundle\ForumBundle\Router\ForumUrlGenerator;

class RoutingExtension extends \Twig_Extension
{
    protected $generator;

    public function __construct(ForumUrlGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Define any of our router's public functions as a twig function
     * @return    array        Functions from ForumUrlGenerator
     */
    public function getFunctions()
    {
        $generator = $this->generator;

        $out = array();
        foreach (get_class_methods($this->generator) as $method) {
            if ($method == '__construct') {
                continue;
            }

            $out[$method] = new \Twig_Function_Method($this, $method);
        }

        return $out;
    }

    /**
     * Proxy any calls to our forum router
     * @param    string        Method being called
     * @param    array         Arguments to pass to method
     * @return   string        Generated URL
     */
    public function __call($method, array $args = array())
    {
        return call_user_func_array(
            array($this->generator, $method),
            $args
        );
    }

    public function getName()
    {
        return 'forum_routing';
    }
}