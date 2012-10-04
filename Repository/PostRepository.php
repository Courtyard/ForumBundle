<?php

namespace Courtyard\Bundle\ForumBundle\Repository;

use Courtyard\Forum\Entity\TopicInterface;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findByTopic(TopicInterface $topic)
    {
        $query = '
            SELECT post
                 , author
              FROM CourtyardForumBundle:Post post
              LEFT JOIN post.author author
             WHERE post.topic = :topic
            ORDER
                BY post.datePosted ASC
        ';

        return $this->getEntityManager()->createQuery($query)
            ->setParameter('topic', $topic->getId())
            ->getResult()
        ;
    }
}