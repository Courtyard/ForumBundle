# Courtyard ForumBundle

This bundle integrates the Courtyard Forum component with Symfony.  Courtyard is a very modular and lightweight forum platform built for Symfony.  We're going to be providing a large suite of extensions for it while keeping the core bundle very small.  

Courtyard isn't like other forum bundles.  It's developed by people who have worked with hundreds of forums over the past decade of all shapes and sizes, up to some of the largest/busiest in the world.  Forums naturally tend to become bloated, so we're designing this with extreme modularity in mind.

Our goal is to offer an alternative to solutions like vBulletin, phpBB, etc. for those who have more demanding technical needs.

**Note**: This is a work in progress! Check back over the next few weeks to see how it's coming along.

## Installation

Download dependencies with composer:

    php composer.phar require courtyard/forum-bundle
    
Add to your - `app/AppKernel.php`:

    new Courtyard\Bundle\ForumBundle\CourtyardForumBundle(),
    
Configure your `app/config/config.yml`:

    courtyard_forum:
        board_class:          Courtyard\Bundle\ForumBundle\Entity\Board
        topic_class:          Courtyard\Bundle\ForumBundle\Entity\Topic
        post_class:           Courtyard\Bundle\ForumBundle\Entity\Post

(cont) You'll also need to tell Doctrine how to map Courtyard's user relationships:

    doctrine:
        orm:
            resolve_target_entities:
                Courtyard\Forum\Entity\UserInterface: YourCo\UserBundle\Entity\User
                
                
Add our routing to `app/config/routing.yml`:

    courtyard_forum:
        resource: "@CourtyardForumBundle/Resources/config/routing.yml"
        prefix:   /forum

(more here later)