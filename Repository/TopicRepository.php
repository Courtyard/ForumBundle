<?php

namespace Courtyard\Bundle\ForumBundle\Repository;

use Courtyard\Forum\Entity\BoardInterface;
use Courtyard\Forum\Repository\TopicRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class TopicRepository extends EntityRepository implements TopicRepositoryInterface
{
    public function findByBoard(BoardInterface $board)
    {
        $query = $this->createQueryBuilder('topic')
            ->leftJoin('topic.author', 'author')
            ->leftJoin('topic.postLast', 'postLast')
            ->leftJoin('postLast.author', 'authorLast')
            ->where('topic.board = :board')
            ->orderBy('topic.dateUpdated', 'DESC')
        ;

        return $this->getEntityManager()->createQuery($query)
            ->setParameter('board', $board->getId())
            ->getResult()
        ;
    }
}