<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Courtyard\Bundle\ForumBundle\Router\ForumUrlGenerator;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class DefineBreadcrumbs
{
    protected $breadcrumbs;
    protected $forumGenerator;

    public function __construct(Breadcrumbs $breadcrumbs, ForumUrlGenerator $forumGenerator)
    {
        $this->breadcrumbs = $breadcrumbs;
        $this->forumGenerator = $forumGenerator;
    }

    public function onKernelRequest(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        $this->breadcrumbs->addItem('Home', '/');


        if (!$board = $request->attributes->get('board')) {
            if (!$topic = $request->attributes->get('topic')) {
                return;
            }

            $board = $topic->getBoard();
        }

        $this->breadcrumbs->addItem($board->getTitle(), $this->forumGenerator->generateBoardUrl($board));

        if (isset($topic)) {
            $this->breadcrumbs->addItem($topic->getTitle(), $this->forumGenerator->generateTopicUrl($topic));
        }
    }
}