<?php

namespace Courtyard\Bundle\ForumBundle\Controller;

use Courtyard\Bundle\ForumBundle\Entity\Board;
use Courtyard\Bundle\ForumBundle\Entity\Post;
use Courtyard\Bundle\ForumBundle\Entity\Topic;
use Courtyard\Manager\ObjectManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostsController extends PublicController
{
    /**
     * View a specific post
     * @param    Post
     * @return   \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Post $post)
    {
        return $this->templating->renderResponse('CourtyardForumBundle:Topics:list.html.twig', array(
            'board'  => $board = $post->getTopic()->getBoard(),
            'topics' => $this->topicRepository->findLatestIn($board)
        ));
    }

    /**
     * Reply to a post/topic
     * @param    Post
     * @return   \Symfony\Component\HttpFoundation\Response
     */
    public function replyAction(Post $post)
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
     * @param    Topic
     * @return   \Symfony\Component\HttpFoundation\Response
     */
    public function replyInlineAction(Topic $topic)
    {
        $reply = new Post();
        $reply->setTopic($topic);

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
     * @param    Post
     * @return   \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Post $post)
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
     * @param    Post
     * @return   \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Post $post)
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