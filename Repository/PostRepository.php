<?php

namespace Courtyard\Bundle\ForumBundle\Repository;

use Courtyard\Forum\Entity\TopicInterface;
use Courtyard\Forum\Repository\PostRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository implements PostRepositoryInterface
{
    public function findByTopic(TopicInterface $topic)
    {
        $query = $this->createQueryBuilder('post')
            ->leftJoin('post.author', 'author')
            ->where('post.topic = :topic')
            ->orderBy('post.datePosted')
        ;

        return $this->getEntityManager()->createQuery($query)
            ->setParameter('topic', $topic->getId())
            ->getResult()
        ;
    }
}