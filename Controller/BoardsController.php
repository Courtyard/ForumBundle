<?php

namespace Courtyard\Forum\Bundle\ForumBundle\Controller;

use Courtyard\Forum\Bundle\ForumBundle\Entity\Board;
use Courtyard\Forum\Bundle\ForumBundle\Entity\Topic;

class BoardsController extends PublicController
{
    /**
     * View all Boards
     * 
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->templating->renderResponse('CourtyardForumBundle:Boards:index.html.twig', array(
            'boards' => $this->boardRepository->findAll()
        ));
    }

    /**
     * View a specific Board, and list all Topics
     * 
     * @param    Courtyard\Forum\Entity\Board
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Board $board)
    {
        return $this->templating->renderResponse('CourtyardForumBundle:Boards:view.html.twig', array(
            'board' => $board,
            'topics' => $this->topicRepository->findByBoard($board)
        ));
    }
}