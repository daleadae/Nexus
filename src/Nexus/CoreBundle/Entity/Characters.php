<?php

namespace Nexus\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Characters
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nexus\CoreBundle\Entity\CharactersRepository")
 */
class Characters
{
    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="character")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Nexus\CoreBundle\Entity\WeeklyUpdate", mappedBy="character", cascade={"persist"})
     */
    private $updates;    

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="experience", type="float")
     */
    private $experience;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var integer
     *
     * @ORM\Column(name="health", type="float")
     */
    private $health;

    /**
     * @var float
     *
     * @ORM\Column(name="attack_speed", type="float")
     */
    private $attackSpeed;

    /**
     * @var float
     *
     * @ORM\Column(name="power", type="float")
     */
    private $power;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255)
     */
    private $avatar;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Characters
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     * @return Characters
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        // XP Change -> Calc new level
        $this->setLevel($this->getLevelForExperience($experience));

        return $this;
    }

    /**
     * Get experience
     *
     * @return integer 
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Characters
     */
    public function setLevel($level)
    {
        $this->level = $level;

        $power = 1+($level-1)/10;
        $this->setPower($power);

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set health
     *
     * @param float $health
     * @return Characters
     */
    public function setHealth($health)
    {
        $this->health = $health;
        if ($this->health <= 0)  {
            $this->processDeath();
        }

        return $this;
    }

    /**
     * Get health
     *
     * @return float 
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Set attackSpeed
     *
     * @param float $attackSpeed
     * @return Characters
     */
    public function setAttackSpeed($attackSpeed)
    {
        $this->attackSpeed = $attackSpeed;

        return $this;
    }

    /**
     * Get attackSpeed
     *
     * @return float 
     */
    public function getAttackSpeed()
    {
        return $this->attackSpeed;
    }

    /**
     * Set power
     *
     * @param float $power
     * @return Characters
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return float 
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     * @return Characters
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set user
     *
     * @param \Application\Sonata\UserBundle\Entity\User $user
     * @return Characters
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return ($this->getName()) ? : '-';
    }
      
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->updates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add updates
     *
     * @param \Nexus\CoreBundle\Entity\WeeklyUpdate $updates
     * @return Characters
     */
    public function addUpdate(\Nexus\CoreBundle\Entity\WeeklyUpdate $updates)
    {
        $this->updates[] = $updates;
        $updates->setCharacter($this);

        return $this;
    }

    /**
     * Remove updates
     *
     * @param \Nexus\CoreBundle\Entity\WeeklyUpdate $updates
     */
    public function removeUpdate(\Nexus\CoreBundle\Entity\WeeklyUpdate $updates)
    {
        $this->updates->removeElement($updates);
    }

    /**
     * Get updates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUpdates()
    {
        return $this->updates;
    }

    /**
     * Process Damage Taken
     */
    public function processDamageTaken($damage)
    {
        $health = $this->getHealth();
        $health -= $damage;
        $this->setHealth($health);
    }

    /**
     * Process Death
     */
    public function processDeath()
    {
        $this->setHealth(100);
        $experience = round($this->getExperience() - ($this->getExperience() * 0.1));
        $this->setExperience($experience);
    }

    /**
     * Get Experience Array
     * @return integer
    */
    public function getLevelForExperience($experience)
    {
        $level = sqrt($experience+10000)-100;
        return floor($level);
    }
}
