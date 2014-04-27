<?php

namespace Nexus\CoreBundle\Models;


/**
 * UnitModel
 * Classic Unit property
 */
class UnitModel
{
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
        $experience_current = $this->getExperienceForLevel($this->getLevel());
        $experience_next = $this->getExperienceForLevel($this->getLevel()+1);
        
        $experience_level = $experience_next - $experience_current;

        $experience_current_level = $this->getExperience() - $experience_current;

        $percent = ($experience_current_level * 100)/$experience_level;

        return $percent;
    }

    /**
     * Get Character DPS
     * @return integer
    */
    public function getDPS()
    {
        /*var_dump($this->getPower());
        var_dump($this->getAttackSpeed());
        var_dump($this->getPower() * $this->getAttackSpeed());*/
        $dps = round($this->getPower() * $this->getAttackSpeed(), 2);
        return $dps;
    }    
}
