<?php

namespace Courtyard\Bundle\ForumBundle\Repository;

use Courtyard\Forum\Entity\BoardInterface;
use Doctrine\ORM\EntityRepository;

class TopicRepository extends EntityRepository
{
    public function findByBoard(BoardInterface $board)
    {
        $query = '
            SELECT topic
                 , author
              FROM CourtyardForumBundle:Topic topic
              LEFT JOIN topic.author author
             WHERE topic.board = :board
            ORDER
               BY topic.datePosted DESC
        ';

        return $this->getEntityManager()->createQuery($query)
            ->setParameter('board', $board->getId())
            ->getResult()
        ;
    }
}