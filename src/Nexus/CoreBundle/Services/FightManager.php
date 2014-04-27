<?php

namespace Nexus\CoreBundle\Services;

class FightManager
{
    private $em;
    private $player;
    private $mob;
    private $result;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function addPlayer(\Nexus\CoreBundle\Entity\Characters $player) {
    	$this->player = $player;
    }

    public function addMonster(\Nexus\CoreBundle\Entity\Monster $monster) {
    	$this->mob = $monster;
    	$this->setupMob();
    }

    public function processFight()
    {

        if ($this->player->getFight() > 0) {
            $result['status'] = "success";
            $player_current_hp = $this->player->getHealth();
            $hp_lost = 0;
            // Process Fight
            while ($player_current_hp-$hp_lost > 0 && $this->mob->getHealth() > 0) {
                $this->mob->processDamageTaken($this->player->getDPS()); // Set Mob Current HP - Player DPS
                if ($this->mob->getHealth() > 0) { // If Mob alive
                    $hp_lost += $this->mob->getDPS(); // Stock HP Lost
                    $this->player->processDamageTaken($this->mob->getDPS()); // Set Player Current HP - Mob DPS
                }
                $result['fight'][] = array('player' => $this->player->getHealth(), 'monster' => $this->mob->getHealth());
            }

            if ($this->mob->getHealth() <= 0) { // If Mob Dead
                $this->player->processExperienceGain($this->mob->getExperience()); // Add Mob experience to current player experience
                $this->player->setHealth($this->player->getHealth()+($hp_lost/2)); // Regen Player HP !
            }

            $this->player->setFight($this->player->getFight()-1);
            $this->savePlayerState();

            $result['monster'] = $this->mob;            
            $result['character'] = $this->player;
        } else {
            $result['status'] = "error";
            $result['message'] = "You need to rest before fighting again.";
        }
        return $result;
    }

    private function setupMob() {
        $this->setupMobLevel();
        $this->setupMobType();
    }

    private function setupMobLevel() {
        $random = rand(1,100);
        if ($random >= 1 && $random < 60) {         // 1-59 -> Mob = Player Level
            $this->mob->setLevel($this->player->getLevel());
        } else if ($random >= 60 && $random < 90) { // 60-89 -> Mob = Player Level +1
            $this->mob->setLevel($this->player->getLevel()+1);
        } else {                                    // 90+ -> Mob = Player Level +2
            $this->mob->setLevel($this->player->getLevel()+2);
        }        
    }

    private function setupMobType() {
        $random = rand(1,100);
        if ($random >= 0 && $random <= 80) {   // 1-79 -> Mob = normal 
            $this->mob->setType(1);
        } else {                                // 80+ -> Mob = elite
            $this->mob->setType(2);
        }       
    } 

    private function savePlayerState() {
        $this->em->persist($this->player);
        $this->em->flush();
    }
}