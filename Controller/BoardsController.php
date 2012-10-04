<?php

namespace Courtyard\Bundle\ForumBundle\Controller;

use Courtyard\Forum\Entity\BoardInterface;

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
     * @param    Courtyard\Forum\Entity\BoardInterface
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(BoardInterface $board)
    {
        return $this->templating->renderResponse('CourtyardForumBundle:Boards:view.html.twig', array(
            'board' => $board,
            'topics' => $this->topicRepository->findByBoard($board)
        ));
    }
}