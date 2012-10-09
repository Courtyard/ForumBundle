<?php

namespace Courtyard\Bundle\ForumBundle\EventListener;

use Courtyard\Bundle\ForumBundle\EventListener\AddQuickReply;

class AddQuickReplyTest extends \PHPUnit_Framework_TestCase
{
    public function testFormVariableIsSet()
    {
        $postManager = $this->getMock('Courtyard\Forum\Manager\ObjectManagerInterface');
        $postManager
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($topic = $this->getMock('Courtyard\Forum\Entity\Topic')))
        ;

        $formView = $this->getMockBuilder('Symfony\Component\Form\FormView')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $form = $this->getMock('Symfony\Component\Form\Tests\FormInterface');
        $form
            ->expects($this->once())
            ->method('createView')
            ->will($this->returnValue($formView))
        ;

        $formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');
        $formFactory
            ->expects($this->once())
            ->method('create')
            ->with('forum_reply_inline', $topic)
            ->will($this->returnValue($form))
        ;

        $response = $this->getMockBuilder('Courtyard\Forum\Templating\TemplateResponse')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $response
            ->expects($this->once())
            ->method('setVariable')
            ->with('form', $formView)
        ;

        $event = $this->getMockBuilder('Courtyard\Forum\Event\TemplateEvent')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $event
            ->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response))
        ;
        
        $listener = new AddQuickReply($formFactory, $postManager);
        $listener->onTopicView($event);
    }
}