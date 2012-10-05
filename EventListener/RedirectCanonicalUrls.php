<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class RedirectCanonicalUrls
{
    public function onKernelRequest(FilterControllerEvent $event)
    {
    }
}