<?php

namespace Nexus\CoreBundle\Services;

class FightManager
{
    private $em;
    private $character;
    private $monster;
    private $result;
    private $logger;

    public function __construct($em, $security, \Nexus\CoreBundle\Services\FightLogger $logger)
    {
        $this->em = $em; // Set EntityManger Service
        $this->character = $security->getToken()->getUser()->getCharacter(); // Set Character
        $this->logger = $logger; // Set FightLogger Service
        $this->setupMonster();
    }

    public function launchFight() {
        if ($this->character->getFight() > 0) { // If the character can fight
            $this->logger->setupLogFight($this->character, $this->monster); // Setup FightLogger Service
            $this->processFight(); // Process fighting between character & monster
            $this->finishFight(); // Finish Fighting 
            $this->logger->finishLogFight(); // Finish FightLogger Service             
        } else { // Character can't fight
            $this->result['status'] = "error";
            $this->result['info']['message'] = "You need to rest before fighting again.";            
        }

        return $this->result;
    }

    private function processFight()
    {
        $this->result['status'] = "success"; // Character can fight
        $character_current_hp = $this->character->getHealth(); // Save current character HP
        $hp_lost = 0;
        // Process Fight
        while ($character_current_hp-$hp_lost > 0 && $this->monster->getHealth() > 0) {
            $this->monster->processDamageTaken($this->character->getDPS()); // Set Monster Current HP - Character DPS
            if ($this->monster->getHealth() > 0) { // If Monster alive
                $hp_lost += $this->monster->getDPS(); // Stock HP Lost
                $this->character->processDamageTaken($this->monster->getDPS()); // Set Character Current HP - Monster DPS
            }
            $this->result['fight'][] = array('character' => $this->character->getHealth(), 'monster' => $this->monster->getHealth());
        }

        if ($this->monster->getHealth() <= 0) { // If Monster Dead
            $this->character->processExperienceGain($this->monster->getExperienceReward()); // Add Monster experience to current character experience
            $this->character->setHealth($this->character->getHealth()+($hp_lost/2)); // Regen Character HP !
            $this->result['fight'][] = array('character' => $this->character->getHealth(), 'monster' => 'dead'); // Final step -> Player regen & Monster die
            $this->result['info']['type'] = 'success';
            $this->result['info']['message'] = '<strong>Victory!</strong> You gain <strong>'.$this->monster->getExperienceReward().'</strong> xp.';
        } else {
            $this->result['info']['type'] = 'danger';
            $this->result['info']['message'] = '<strong>Defeat!</strong> You die and lose some of your xp.';
        }        
    }

    private function finishFight()
    {
        $this->character->setFight($this->character->getFight()-1); // Remove one to total fight allowed

        $this->save($this->character); // Save character state
        $this->result['monster'] = $this->monster; // Monster state after fight
        $this->result['character'] = $this->character; // Character state after fight
    }

    private function setupMonster() {
        $monster_rep = $this->em->getRepository('NexusCoreBundle:Monster');
        $monsters = $monster_rep->findAll();
        $this->monster = $monsters[rand(0,count($monsters)-1)]; // Set monster random
        $this->setupMonsterLevel(); // Set Monster Level
        $this->setupMonsterType(); // Set Monster Type & Info
    }    

    private function setupMonsterLevel() {
        $random = rand(1,100);
        if ($random >= 1 && $random < 60) {         // 1-59 -> Monster = Character Level
            $this->monster->setLevel($this->character->getLevel());
        } else if ($random >= 60 && $random < 90) { // 60-89 -> Monster = Character Level +1
            $this->monster->setLevel($this->character->getLevel()+1);
        } else {                                    // 90+ -> Monster = Character Level +2
            $this->monster->setLevel($this->character->getLevel()+2);
        }        
    }

    private function setupMonsterType() {
        $random = rand(1,100);
        if ($random >= 0 && $random <= 80) {   // 1-79 -> Monster = normal 
            $this->monster->setType(1);
        } else {                                // 80+ -> Monster = elite
            $this->monster->setType(2);
        }       
    } 

    private function save($entity) {
        return $this
            ->persist($entity)
            ->flush()
        ;
    }

    private function persist($entity) {
        $this->em->persist($entity);

        return $this;
    }

    private function flush() {
        $this->em->flush();

        return $this;
    }
}