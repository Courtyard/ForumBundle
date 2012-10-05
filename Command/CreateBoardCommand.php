<?php

namespace Courtyard\Bundle\ForumBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateBoardCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('courtyard:board:create')
            ->setDescription('Create a board')
            ->setDefinition(array(
                new InputArgument('title', InputArgument::REQUIRED, 'The title of the board')
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $boardManager = $this->getContainer()->get('courtyard_forum.manager.board');
        $board = $boardManager->createNew();
        $board->setTitle($input->getArgument('title'));
        $boardManager->create($board);
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('title')) {
            $title = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a title:',
                function($title) {
                    if (empty($title)) {
                        throw new \Exception('Title cannot be empty');
                    }

                    return $title;
                }
            );

            $input->setArgument('title', $title);
        }
    }
}
