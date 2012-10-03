<?php

namespace Courtyard\Forum\Bundle\ForumBundle\Controller;

use Courtyard\Forum\Bundle\ForumBundle\Entity\Post;
use Courtyard\Forum\Bundle\ForumBundle\Entity\Board;
use Courtyard\Forum\Bundle\ForumBundle\Entity\Topic;
use Courtyard\Forum\Manager\ObjectManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TopicsController extends PublicController
{
    /**
     * @var    Courtyard\Forum\Manager\ObjectManagerInterface
     */
    protected $manager;
    
    /**
     * List the topics in a Board
     * @param    Courtyard\Forum\Entity\Board
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Board $board)
    {
        return $this->templating->renderResponse('CourtyardForumBundle:Topics:list.html.twig', array(
            'board' => $board,
            'topics' => $this->topicRepository->findLatestIn($board)
        ));
    }
    
    /**
     * Create a new Topic in Board
     * 
     * @param    Courtyard\Forum\Entity\Board
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Board $board)
    {
        $topic = new Topic();
        $topic->setBoard($board);
        
        $form = $this->formFactory->create('forum_topic', $topic);

        if ($this->request->getMethod() == 'POST') {
            $form->bindRequest($this->request);
        
            if ($form->isValid()) {
                $this->manager->create($topic);
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
     * @param    Courtyard\Forum\Entity\Topic
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Topic $topic)
    {
        $reply = new Post();
        $reply->setTopic($topic);
        $form = $this->formFactory->create('forum_reply_inline', $reply);
        
        return $this->templating->renderResponse('CourtyardForumBundle:Topics:view.html.twig', array(
            'topic' => $topic,
            'board' => $topic->getBoard(),
            'posts' => $this->postRepository->findByTopic($topic),
            'form'  => $form->createView()
        ));
    }
    
    /**
     * Bring the relevant ObjectManager into scope to save Topics
     * @param    Courtyard\Forum\Manager\ObjectManagerInterface
     */
    public function setTopicManager(ObjectManagerInterface $manager)
    {
        $this->manager = $manager;
    }
}