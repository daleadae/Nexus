<?php

namespace Nexus\CoreBundle\Entity;

use Nexus\CoreBundle\Models\UnitModel as BaseUnit;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * Characters
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nexus\CoreBundle\Entity\CharactersRepository")
 * @ExclusionPolicy("none")
 */
class Characters extends BaseUnit
{
    /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="character")
     * @ORM\JoinColumn(nullable=false)
     * @Exclude
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Nexus\CoreBundle\Entity\WeeklyUpdate", mappedBy="character", cascade={"persist", "remove"})
     * @Exclude
     */
    private $updates;

    /**
     * @ORM\OneToMany(targetEntity="Nexus\CoreBundle\Entity\FightLog", mappedBy="character", cascade={"persist", "remove"})
     * @Exclude
     */
    private $fightLogs;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Exclude
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="fight", type="integer", options={"default" = 3})
     */
    private $fight;

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
     * @var float
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
     * Set experience
     *
     * @param integer $experience
     * @return Characters
     */
    public function setExperience($experience)
    {
        $this->experience = round($experience);

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
        if ($level > $this->level) {
            $this->setHealth(100);
        }

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
     * Set fight
     *
     * @param integer $fight
     * @return Characters
     */
    public function setFight($fight)
    {
        $this->fight = $fight;

        return $this;
    }

    /**
     * Get fight
     *
     * @return integer 
     */
    public function getFight()
    {
        return $this->fight;
    }


    /**
     * Set health
     *
     * @param float $health
     * @return Characters
     */
    public function setHealth($health)
    {
        $this->health = round($health, 2);
        if ($this->health <= 0)  {
            $this->processDeath();
        } else if ($this->health > 100) {
            $this->health = 100;
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
        if (isset($this->getUser)) {
            return $this->getUser()->getUsername();
        } else {
            return '-';
        }
    }
      
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->updates = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fightLogs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fight = 3;
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
     * Process Death
     */
    public function processDeath()
    {
        $this->setHealth(100);
        $experience = ($this->getExperienceForLevel($this->level+1) - $this->getExperienceForLevel($this->level))*0.3;
        $this->processExperienceLost($experience);
    }    

    /**
     * Add fightLogs
     *
     * @param \Nexus\CoreBundle\Entity\FightLog $fightLogs
     * @return Characters
     */
    public function addFightLog(\Nexus\CoreBundle\Entity\FightLog $fightLogs)
    {
        $this->fightLogs[] = $fightLogs;
        $fightLogs->setCharacter($this);

        return $this;
    }

    /**
     * Remove fightLogs
     *
     * @param \Nexus\CoreBundle\Entity\FightLog $fightLogs
     */
    public function removeFightLog(\Nexus\CoreBundle\Entity\FightLog $fightLogs)
    {
        $this->fightLogs->removeElement($fightLogs);
    }

    /**
     * Get fightLogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFightLogs()
    {
        return $this->fightLogs;
    }
}
