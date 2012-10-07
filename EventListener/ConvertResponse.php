<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

use Courtyard\Forum\Event\TemplateEvent;
use Courtyard\Forum\Templating\TemplateResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Templating\EngineInterface;

class ConvertResponse
{
    protected $dispatcher;
    protected $templating;
    
    public function __construct(EventDispatcherInterface $dispatcher, EngineInterface $templating)
    {
        $this->dispatcher = $dispatcher;
        $this->templating = $templating;
    }
    
    /**
     * Converts TemplateResponses into Symfony Responses
     * 
     * Renders a TemplateResponses using the configured templating engine.
     * Optionally fires a more specific event, possibly modifying the response template/variables.
     * 
     * @param    Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();
        
        if (!$result instanceof TemplateResponse) {
            return;
        }
        
        if ($eventName = $result->getEvent()) {
            $this->dispatcher->dispatch($eventName, new TemplateEvent($result));
        }
        
        $event->setResponse(new Response($this->templating->render(
            sprintf(
                'CourtyardForumBundle:%s:%s.html.twig',
                $result->getTemplate()->getNamespace(),
                $result->getTemplate()->getTemplate()
            ),
            $result->getVariables()
        )));
    }
}