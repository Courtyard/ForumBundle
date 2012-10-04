<?php

namespace Courtyard\Bundle\ForumBundle\DataFixtures\ORM;

use Courtyard\Bundle\ForumBundle\Entity\Board;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadExampleBoards implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $titles = array(
            'Main Forum',
            'Secondary Forum'
        );

        foreach ($titles as $title) {
            $board = new Board();
            $board->setTitle($title);

            $manager->persist($board);
        }

        $manager->flush();
    }
}