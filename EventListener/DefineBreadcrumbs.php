<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

use Courtyard\Forum\Router\ForumUrlGeneratorInterface;
use Courtyard\Bundle\ForumBundle\Controller\TopicsController;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class DefineBreadcrumbs
{
    protected $breadcrumbs;
    protected $forumGenerator;

    public function __construct(Breadcrumbs $breadcrumbs, ForumUrlGeneratorInterface $forumGenerator)
    {
        $this->breadcrumbs = $breadcrumbs;
        $this->forumGenerator = $forumGenerator;
    }

    public function onKernelRequest(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        list($controller, $method) = $event->getController();

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
        
        if ($controller instanceof TopicsController and $method == 'postAction') {
            $this->breadcrumbs->addItem('Post New Topic', $this->forumGenerator->generateNewTopicUrl($board));
        }
    }
}