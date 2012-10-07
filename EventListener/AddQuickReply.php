<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

use Courtyard\Forum\Event\TemplateEvent;
use Courtyard\Forum\Manager\ObjectManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class AddQuickReply
{
    protected $formFactory;
    protected $postManager;

    public function __construct(FormFactoryInterface $formFactory, ObjectManagerInterface $postManager)
    {
        $this->formFactory = $formFactory;
        $this->postManager = $postManager;
    }

    public function onTopicView(TemplateEvent $event)
    {
        $response = $event->getResponse();
        $form = $this->formFactory->create('forum_reply_inline', $this->postManager->create($response->getVariable('topic')));
        $response->setVariable('form', $form->createView());
    }
}