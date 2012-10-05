<?php

namespace Courtyard\Bundle\ForumBundle\Router;

use Courtyard\Forum\Entity\BoardInterface;
use Courtyard\Forum\Entity\TopicInterface;
use Courtyard\Forum\Entity\PostInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ForumUrlGenerator
{
    protected $generator;
    protected $topicsPerPage;
    protected $postsPerPage;

    public function __construct(UrlGeneratorInterface $generator, $topicsPerPage = 25, $postsPerPage = 40)
    {
        $this->generator = $generator;
        $this->topicsPerPage = $topicsPerPage;
        $this->postsPerPage = $postsPerPage;
    }

    public function generateBoardUrl(BoardInterface $board, $absolute = false)
    {
        return $this->generator->generate('forum_view', array(
            'id' => $board->getId()
        ), $absolute);
    }

    public function generateNewTopicUrl(BoardInterface $board, $absolute = false)
    {
        return $this->generator->generate('forum_topic_create', array(
            'id' => $board->getId()
        ), $absolute);
    }

    public function generateTopicUrl(TopicInterface $topic, $absolute = false)
    {
        return $this->generator->generate('forum_topic_view', array(
            'id' => $topic->getId()
        ), $absolute);
    }

    public function generateTopicReplyUrl(PostInterface $post, $absolute = false)
    {
        return $this->generator->generate('forum_reply', array(
            'id' => $post->getId()
        ), $absolute);
    }

    public function generateTopicReplyInlineUrl(TopicInterface $topic, $absolute = false)
    {
        return $this->generator->generate('forum_reply_inline', array(
            'id' => $topic->getId()
        ), $absolute);
    }
    
    public function generatePostUrl(PostInterface $post, $absolute = false)
    {
        return $this->generateTopicUrl($post->getTopic(), $absolute);
    }
}