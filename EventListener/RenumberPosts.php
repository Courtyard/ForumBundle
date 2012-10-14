<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

use Courtyard\Forum\Manager\DataRebuild\Post\RenumberPosts as Rebuilder;
use Courtyard\Forum\Event\PostEvent;

class RenumberPosts
{
    protected $rebuilder;

    public function __construct(Rebuilder $rebuilder)
    {
        $this->rebuilder = $rebuilder;
    }

    public function onPostDelete(PostEvent $event)
    {
        $posts = $this->rebuilder->renumber($event->getPost()->getTopic());

        foreach ($posts as $post) {
            $event->addEntityToPersist($post);
        }
    }
}