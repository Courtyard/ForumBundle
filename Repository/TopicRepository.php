<?php

namespace Courtyard\Bundle\ForumBundle\Repository;

use Courtyard\Forum\Entity\BoardInterface;
use Courtyard\Forum\Repository\TopicRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class TopicRepository extends EntityRepository implements TopicRepositoryInterface
{
    public function findByBoard(BoardInterface $board)
    {
        $query = '
            SELECT topic
                 , author
                 , postLast
                 , authorLast
              FROM CourtyardForumBundle:Topic topic
              LEFT JOIN topic.author author
              LEFT JOIN topic.postLast postLast
              LEFT JOIN postLast.author authorLast
             WHERE topic.board = :board
            ORDER
               BY topic.dateUpdated DESC
        ';

        return $this->getEntityManager()->createQuery($query)
            ->setParameter('board', $board->getId())
            ->getResult()
        ;
    }
}