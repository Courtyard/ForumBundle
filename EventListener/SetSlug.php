<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

use Courtyard\Forum\ForumEvents;
use Courtyard\Forum\Event\BoardEvent;
use Courtyard\Forum\Event\TopicEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SetSlug implements EventSubscriberInterface
{
    /**
     * @var    Closure        Callback to inflector
     */
    protected $inflect;

    public function __construct($inflectorClass)
    {
        $this->inflect = function($text) use ($inflectorClass) {
            return call_user_func(array($inflectorClass, 'slugify'), $text);
        };
    }

    public function onPreBoard(BoardEvent $event)
    {
        $inflector = $this->inflect;

        $board = $event->getBoard();
        $board->setSlug($inflector($board->getTitle()));
    }

    public function onPreTopic(TopicEvent $event)
    {
        $inflector = $this->inflect;

        $topic = $event->getTopic();
        $topic->setSlug($inflector($topic->getTitle()));
    }

    static public function getSubscribedEvents()
    {
        return array(
            ForumEvents::BOARD_CREATE_PRE => 'onPreBoard',
            ForumEvents::TOPIC_CREATE_PRE => 'onPreTopic'
        );
    }
}