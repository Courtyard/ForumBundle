<?php

namespace Courtyard\Bundle\ForumBundle\Controller;

use Courtyard\Forum\Entity\BoardInterface;
use Courtyard\Forum\Entity\TopicInterface;
use Courtyard\Forum\Entity\PostInterface;
use Courtyard\Bundle\ForumBundle\Entity\Topic;
use Courtyard\Bundle\ForumBundle\Entity\Post; 
use Courtyard\Forum\Manager\ObjectManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostsController extends PublicController
{
    /**
     * View a specific post
     * @param    Courtyard\Forum\Entity\PostInterface
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(PostInterface $post)
    {
        return $this->templating->renderResponse('CourtyardForumBundle:Topics:list.html.twig', array(
            'board'  => $board = $post->getTopic()->getBoard(),
            'topics' => $this->topicRepository->findLatestIn($board)
        ));
    }

    /**
     * Reply to a post/topic
     * @param    Courtyard\Forum\Entity\PostInterface
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function replyAction(PostInterface $post)
    {
        $reply = new Post();
        $reply->setParent($post);

        $form = $this->formFactory->create('forum_post_reply', $reply);

        if ($this->request->getMethod() == 'POST') {
            $form->bindRequest($this->request);

            if ($form->isValid()) {
                $this->manager->create($reply);
                $this->session->addFlash('success', 'Message posted successfully.');
                return new RedirectResponse($this->router->generateUrl('forum_post_view', array('id' => $reply->getId())));
            }
        }

        return $this->templating->renderResponse('CourtyardForumBundle:Posts:reply.html.twig', array(
            'topic' => $topic,
            'board' => $topic->getBoard(),
            'posts' => $this->postRepository->findAllByTopic($topic)
        ));
    }

    /**
     * Reply to a post/topic
     * @param    Courtyard\Forum\Entity\TopicInterface
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function replyInlineAction(TopicInterface $topic)
    {
        $reply = $this->manager->createNew($topic);
        $form = $this->formFactory->create('forum_reply_inline', $reply);

        if ($this->request->getMethod() == 'POST') {
            $form->bindRequest($this->request);

            if ($form->isValid()) {
                $this->manager->create($reply);
                $this->session->getFlashBag()->add('success', 'Message posted successfully.');
                return new RedirectResponse($this->router->generate('forum_topic_view', array('id' => $topic->getId())));
            }
        }

        return $this->templating->renderResponse('CourtyardForumBundle:Posts:reply.html.twig', array(
            'topic' => $topic,
            'board' => $topic->getBoard(),
            'posts' => $this->postRepository->findAllByTopic($topic)
        ));
    }

    /**
     * Edit to a specific Post
     * @param    Courtyard\Forum\Entity\PostInterface
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function editAction(PostInterface $post)
    {
        $form = $this->formFactory->create('forum_post_edit', $post);

        if ($this->request->getMethod() == 'POST') {
            $form->bindRequest($this->request);

            if ($form->isValid()) {
                $this->manager->update($post);
                $this->session->getFlashBag()->add('success', 'Message updated successfully.');
                return new RedirectResponse($this->router->generateUrl('forum_post_view', array('id' => $reply->getId())));
            }
        }

        return $this->templating->renderResponse('CourtyardForumBundle:Posts:edit.html.twig', array(
            'topic' => $topic,
            'board' => $topic->getBoard(),
            'posts' => $this->postRepository->findAllByTopic($topic)
        ));
    }

    /**
     * Delete a specific Post
     * @param    Courtyard\Forum\Entity\PostInterface
     * @return   Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(PostInterface $post)
    {

    }

    /**
     * Bring the relevant ObjectManager into scope to save Topics
     * @param    Courtyard\Forum\Manager\ObjectManagerInterface
     */
    public function setPostManager(ObjectManagerInterface $manager)
    {
        $this->manager = $manager;
    }
}