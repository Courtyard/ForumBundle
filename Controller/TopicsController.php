<?php

namespace Courtyard\Bundle\ForumBundle\Controller;

use Courtyard\Forum\Entity\BoardInterface;
use Courtyard\Forum\Entity\TopicInterface;
use Courtyard\Forum\Entity\PostInterface;
use Courtyard\Bundle\ForumBundle\Entity\Post;
use Courtyard\Bundle\ForumBundle\Entity\Board;
use Courtyard\Bundle\ForumBundle\Entity\Topic;
use Courtyard\Forum\Manager\ObjectManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TopicsController extends PublicController
{
    /**
     * @var    Courtyard\Forum\Manager\ObjectManagerInterface
     */
    protected $topicManager;

    /**
     * @var    Courtyard\Forum\Manager\ObjectManagerInterface
     */
    protected $postManager;
    
    
    /**
     * List the topics in a Board
     * @param    Courtyard\Forum\Entity\BoardInterface
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function listAction(BoardInterface $board)
    {
        return $this->templating->renderResponse('CourtyardForumBundle:Topics:list.html.twig', array(
            'board' => $board,
            'topics' => $this->topicRepository->findLatestIn($board)
        ));
    }

    /**
     * Create a new Topic in Board
     * 
     * @param    Courtyard\Forum\Entity\BoardInterface
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function postAction(BoardInterface $board)
    {
        $topic = $this->topicManager->createNew($board);
        $form = $this->formFactory->create('forum_topic', $topic);

        if ($this->request->getMethod() == 'POST') {
            $form->bindRequest($this->request);

            if ($form->isValid()) {
                $this->topicManager->create($topic);
                $this->session->getFlashBag()->add('success', 'Topic posted successfully.');
                return new RedirectResponse($this->router->generate('forum_topic_view', array('id' => $topic->getId())));
            }
        }

        return $this->templating->renderResponse('CourtyardForumBundle:Topics:post.html.twig', array(
            'board' => $board,
            'form' => $form->createView()
        ));
    }

    /**
     * View a Topic
     * 
     * @param    Courtyard\Forum\Entity\TopicInterface
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(TopicInterface $topic)
    {
        $form = $this->formFactory->create('forum_reply_inline', $this->postManager->createNew($topic));

        return $this->templating->renderResponse('CourtyardForumBundle:Topics:view.html.twig', array(
            'topic' => $topic,
            'board' => $topic->getBoard(),
            'posts' => $this->postRepository->findByTopic($topic),
            'form'  => $form->createView()
        ));
    }

    /**
     * @param    Courtyard\Forum\Manager\ObjectManagerInterface
     */
    public function setTopicManager(ObjectManagerInterface $manager)
    {
        $this->topicManager = $manager;
    }
    
    /**
     * @param    Courtyard\Forum\Manager\ObjectManagerInterface
     */
    public function setPostManager(ObjectManagerInterface $manager)
    {
        $this->postManager = $manager;
    }
}