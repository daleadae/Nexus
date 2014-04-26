<?php

/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * This file has been generated by the Sonata EasyExtends bundle ( http://sonata-project.org/bundles/easy-extends )
 *
 * References :
 *   working with object : http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 *
 * @author <yourname> <youremail>
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Nexus\CoreBundle\Entity\Characters", mappedBy="user")
     */
    private $character;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *         
     * @param  \Nexus\CoreBundle\Entity\Characters $character
     * @return Characters
     */
    public function setCharacter(\Nexus\CoreBundle\Entity\Characters $character)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Nexus\CoreBundle\Entity\Characters $character
     */
    public function getCharacter()
    {
        return $this->character;
    }

}