# Installation

For a fully working, configured example application, check out [Courtyard/ForumDistribution](https://github.com/Courtyard/ForumDistribution).  It's meant to be a sandbox to test the application quickly.

## Requirements

- **User Entity**: In order to use ForumBundle, you'll need your own User entity.  It can be stand-alone, or you can use FOSUserBundle.  You'll just need to have your entity implement `Courtyard\Forum\Entity\UserInterface`.
- **Doctrine ORM**: Currently, Courtyard is only compatible with Doctrine ORM, and not the ODM or Propel.  PRs welcome!

## Steps

Download dependencies with composer:

    php composer.phar require courtyard/forum-bundle

Create a new application-space bundle which extends the forum bundle:

    mkdir -p src/Acme/ForumBundle/Entity
    
`src/Acme/ForumBundle/AcmeForumBundle.php`

    <?php
    
    namespace Acme\ForumBundle;
    
    use Symfony\Component\HttpKernel\Bundle\Bundle;
    
    class AcmeForumBundle extends Bundle
    {
        public function getParent()
        {
            return 'CourtyardForumBundle';
        }
    }    

Due to how Doctrine handles entity inheritence, all of your entities will live in your application namespace.  Any new modifications or extensions to your entities will happen here.


`src/Acme/ForumBundle/Entity/Board.php`
    
    <?php
    
    namespace Acme\ForumBundle\Entity;
    
    use Courtyard\Bundle\ForumBundle\Entity\Board as BaseBoard;
    use Doctrine\ORM\Mapping as ORM;
    
    /**
     * @ORM\Entity
     * @ORM\Table(name="forum_board")
     */
    class Board extends BaseBoard
    {
    
    }

`src/Acme/ForumBundle/Entity/Topic.php`

    <?php
    
    namespace Acme\ForumBundle\Entity;
    
    use Courtyard\Bundle\ForumBundle\Entity\Topic as BaseTopic;
    use Doctrine\ORM\Mapping as ORM;
    
    /**
     * @ORM\Entity
     * @ORM\Table(name="forum_topic")
     */
    class Topic extends BaseTopic
    {
        /**
         * @ORM\ManyToOne(targetEntity="Board")
         */
        protected $board;
    
        /**
         * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User")
         */
        protected $author;
    
        /**
         * @ORM\ManyToOne(targetEntity="Post")
         * @ORM\JoinColumn(name="postFirst_id")
         */
        protected $postFirst;
    
        /**
         * @ORM\ManyToOne(targetEntity="Post")
         * @ORM\JoinColumn(name="postLast_id")
         */
        protected $postLast;
    }

`src/Acme/ForumBundle/Entity/Post.php`

    <?php
    
    namespace Acme\ForumBundle\Entity;
    
    use Courtyard\Bundle\ForumBundle\Entity\Post as BasePost;
    use Doctrine\ORM\Mapping as ORM;
    
    /**
     * @ORM\Entity
     * @ORM\Table(name="forum_post")
     */
    class Post extends BasePost
    {
        /**
         * @ORM\ManyToOne(targetEntity="Topic")
         */
        protected $topic;
        
        /**
         * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User")
         */
        protected $author;
    }

Register the bundles in `app/AppKernel.php`:

    new Courtyard\Bundle\ForumBundle\CourtyardForumBundle(),
    new Acme\ForumBundle\AcmeForumBundle(),

Configure your `app/config/config.yml`:

    courtyard_forum:
        board_class:          Acme\ForumBundle\Entity\Board
        topic_class:          Acme\ForumBundle\Entity\Topic
        post_class:           Acme\ForumBundle\Entity\Post
                
Add routing to `app/config/routing.yml`:

    courtyard_forum:
        resource: "@CourtyardForumBundle/Resources/config/routing.yml"
        prefix:   /forum
        
Add the new database tables:

    app/console doctrine:schema:update
    
Finally, add a new board:

    app/console courtyard:board:create
    
You should be able to navigate to /forum (or wherever your router is configured) to see the added forum.