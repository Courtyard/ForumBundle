<?php

namespace Courtyard\Forum\Bundle\ForumBundle\Controller;

use Courtyard\Forum\Manager\ObjectManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\EngineInterface;

class PublicController
{
    protected $request;
    protected $session;
    protected $router;
    protected $container;
    protected $templating;
    protected $formFactory;

    protected $topicRepository;
    protected $postRepository;
    protected $boardRepository;

    public function __construct(Request $request, SessionInterface $session, RouterInterface $router, ContainerInterface $container, EngineInterface $templating, FormFactoryInterface $formFactory)
    {
        $this->request = $request;
        $this->session = $session;
        $this->router  = $router;
        $this->container = $container;
        $this->templating = $templating;
        $this->formFactory = $formFactory;
    }

    public function setObjectManager(ObjectManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function setTopicRepository(EntityRepository $repository)
    {
        $this->topicRepository = $repository;
    }

    public function setPostRepository(EntityRepository $repository)
    {
        $this->postRepository = $repository;
    }

    public function setBoardRepository(EntityRepository $repository)
    {
        $this->boardRepository = $repository;
    }
}