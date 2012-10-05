<?php

namespace Courtyard\Bundle\ForumBundle\Request\ParamConverter;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;

class EntityConverter implements ParamConverterInterface
{
    protected $em;
    protected $classes;
    protected $types = array(
        'Courtyard\Forum\Entity\BoardInterface' => 'board',
        'Courtyard\Forum\Entity\TopicInterface' => 'topic',
        'Courtyard\Forum\Entity\PostInterface' => 'post'
    );

    public function __construct(EntityManager $em, $boardClass, $topicClass, $postClass)
    {
        $this->em = $em;
        $this->classes = array(
            'Courtyard\Forum\Entity\BoardInterface' => $boardClass,
            'Courtyard\Forum\Entity\TopicInterface' => $topicClass,
            'Courtyard\Forum\Entity\PostInterface' => $postClass
        );
    }

    /**
     * Convert our interface hints into DoctrineParamConverter compatible hints
     *
     * {@inheritDoc}
     */
    public function apply(Request $request, ConfigurationInterface $configuration)
    {
        $parameter = null;
        $interface = $configuration->getClass();
        $className = $this->classes[$interface];

        if (!$param = $this->getRouteParameter($name = $this->types[$interface], $request)) {
            return;
        }

        $field = lcfirst(substr($param, strlen($name)));
        $entity = $this->em->getRepository($className)->findOneBy(array($field => $request->attributes->get($param)));

        if (!$entity) {
            throw new NotFoundHttpException(sprintf('The requested %s could not be found.', $name));
        }

        $request->attributes->set($name, $entity);

        return true;
    }

    protected function getRouteParameter($type, Request $request)
    {
        $matches = null;

        foreach ($request->attributes->all() as $key => $value) {
            if (preg_match("/^$type([A-Z]{1})([a-zA-Z]*)$/", $key, $matches)) {
                return $key;

                $field = lcfirst($matches[1] . $matches[2]);
                return $field;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports(ConfigurationInterface $configuration)
    {
        return isset($this->classes[$configuration->getClass()]);
    }
}