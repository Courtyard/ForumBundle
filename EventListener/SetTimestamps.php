<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

Use Courtyard\Forum\ForumEvents;
use Courtyard\Forum\Event\PostEvent;
use Courtyard\Forum\Event\TopicEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SetTimestamps implements EventSubscriberInterface
{
    public function onPrePost(PostEvent $event)
    {
        $post = $event->getPost();
        $post->setDatePosted(new \DateTime());
        $post->setDateUpdated(new \DateTime());
    }

    public function onPrePostUpdate(PostEvent $event)
    {
        $post = $event->getPost();
        $post->setDateUpdated(new \DateTime());  
        $post->getTopic()->setDateUpdated(new \DateTime());
    }

    public function onPreTopic(TopicEvent $event)
    {
        $topic = $event->getTopic();
        $topic->setDatePosted(new \DateTime());
        $topic->setDateUpdated(new \DateTime());
    }

    public function onPreTopicUpdate(TopicEvent $event)
    {
        $topic = $event->getTopic();
        $topic->setDateUpdated(new \DateTime());
    }

    static public function getSubscribedEvents()
    {
        return array(
            ForumEvents::POST_CREATE_PRE  => 'onPrePost',
            ForumEvents::POST_UPDATE_PRE  => 'onPrePostUpdate',
            ForumEvents::TOPIC_CREATE_PRE => 'onPreTopic',
            ForumEvents::TOPIC_UPDATE_PRE => 'onPreTopicUpdate'
        );
    }
}