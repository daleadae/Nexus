<?php

namespace Nexus\CoreBundle\Models;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Accessor;

/**
 * UnitModel
 * Classic Unit property
 * @ExclusionPolicy("none")
 */
class UnitModel
{
    /**
     * @var float
     * @Accessor(getter="getExperienceShort")
     */
    private $experienceShort;

    /**
     * @var float
     * @Accessor(getter="getExperienceShortMax")
     */
    private $experienceShortMax;

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
     * Process Experience Gain
     */
    public function processExperienceGain($xp)
    {
        $experience = $this->getExperience();
        $experience += $xp;
        $this->setExperience($experience);
    }

    /**
     * Process Experience Lost
     */
    public function processExperienceLost($xp)
    {
        $experience = $this->getExperience();
        $experience -= $xp;
        $this->setExperience($experience);
    }      

    /**
     * Get level for experience
     * @return integer
     */
    public function getLevelForExperience($experience)
    {
        $level = sqrt($experience+10000)-100;
        return floor($level);
    }

    /**
     * Get experience for level
     * @return float
     */
    public function getExperienceForLevel($level)
    {
        $experience =  pow($level, 2) + 200*$level;
        return $experience;
    }

    /**
     * Get experience for level
     * @return float
     */
    public function getPercentLevel()
    {   
        $experience_level = $this->getExperienceShortMax();

        $experience_current_level = $this->getExperienceShort();

        $percent = ($experience_current_level * 100)/$experience_level;

        return $percent;
    }

    /**
     * Get current experience at level (0 / X)
     * @return float
     */
    public function getExperienceShort ()
    {
        $xp_short = $this->getExperience() - $this->getExperienceForLevel($this->getLevel());

        return $xp_short;
    } 

    /**
     * Get get max experience at level (X)
     * @return float
     */
    public function getExperienceShortMax()
    {
        $xp_short_max =  $this->getExperienceForLevel($this->getLevel()+1) -  $this->getExperienceForLevel($this->getLevel());

        return $xp_short_max;
    }

    /**
     * Get Character DPS
     * @return integer
    */
    public function getDPS()
    {
        $dps = round($this->getPower() * $this->getAttackSpeed(), 2);
        return $dps;
    }    
}
