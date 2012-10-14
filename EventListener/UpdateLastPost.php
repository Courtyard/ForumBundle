<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

use Courtyard\Forum\ForumEvents;
use Courtyard\Forum\Event\PostEvent;
use Courtyard\Forum\Repository\PostRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UpdateLastPost implements EventSubscriberInterface
{
    protected $repository;

    public function __construct(PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function onPostDeleteBefore(PostEvent $event)
    {
        $post = $event->getPost();
        $topic = $post->getTopic();

        if ($post == $topic->getPostLast()) {
            $topic->setPostLast(null);

            $event->addEntityToPersist($topic);
        }
    }

    public function onPostDeleteAfter(PostEvent $event)
    {
        $post = $event->getPost();
        $topic = $post->getTopic();

        if (!$topic->getPostLast()) {
            $topic->setPostLast($lastPost = $this->repository->findLastPostByTopic($topic));
            $topic->setDateUpdated($lastPost->getDatePosted());

            $event->addEntityToPersist($topic);
        }
    }

    static public function getSubscribedEvents()
    {
        return array(
            ForumEvents::POST_DELETE_PRE => 'onPostDeleteBefore',
            ForumEvents::POST_DELETE_POST => 'onPostDeleteAfter'
        );
    }
}