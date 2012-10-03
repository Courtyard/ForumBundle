<?php

namespace Courtyard\Forum\Bundle\ForumBundle\EventListener;

use Courtyard\Forum\DataRebuild\Board\Statistics;
use Courtyard\Forum\ForumEvents;
use Courtyard\Forum\Event\TopicEvent;
use Courtyard\Forum\Event\PostEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UpdateBoardCounters implements EventSubscriberInterface
{
    protected $statistics;
    
    public function __construct(Statistics $statistics)
    {
        $this->statistics = $statistics;
    }
    
    public function onTopicCreatePost(TopicEvent $event)
    {
        $this->statistics->addTopic();
        $event->persist($event->getBoard());
    }
    
    public function onTopicDeletePost(TopicEvent $event)
    {
        $this->statistics->removeTopic();
        $event->persist($event->getBoard());
    }
    
    public function onPostCreatePost(PostEvent $event)
    {
        $this->statistics->addPost();
        $event->persist($event->getBoard());
    }
    
    public function onPostDeletePost(PostEvent $event)
    {
        $this->statistics->removePost();
        $event->persist($event->getBoard());
    }
    
    static public function getSubscribedEvents()
    {
        return array(
            ForumEvents::POST_CREATE_POST,
            ForumEvents::TOPIC_CREATE_POST
        );
    }
}