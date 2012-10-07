<?php

namespace Courtyard\Bundle\ForumBundle\Repository;

use Courtyard\Forum\Repository\BoardRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class BoardRepository extends EntityRepository implements BoardRepositoryInterface
{
    public function findBySlug($slug)
    {
        return $this->findOneBy(array('slug' => $slug));
    }
}