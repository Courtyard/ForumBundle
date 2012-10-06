<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

use Courtyard\Forum\ForumEvents;
use Courtyard\Forum\Event\PostEvent;
use Courtyard\Forum\Event\TopicEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SetAuthor implements EventSubscriberInterface
{
    protected $context;

    public function __construct(SecurityContextInterface $context)
    {
        $this->context = $context;
    }

    public function onPrePost(PostEvent $event)
    {
        $post = $event->getPost();
        $post->setAuthor($this->context->getToken()->getUser());
    }

    public function onPreTopic(TopicEvent $event)
    {
        $topic = $event->getTopic();
        $topic->setAuthor($this->context->getToken()->getUser()); 
    }

    static public function getSubscribedEvents()
    {
        return array(
            ForumEvents::POST_CREATE_PRE  => 'onPrePost',
            ForumEvents::TOPIC_CREATE_PRE => 'onPreTopic'
        );
    }
}