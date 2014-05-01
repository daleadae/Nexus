<?php

namespace Nexus\CoreBundle\Services;
use Nexus\CoreBundle\Entity\FightLog;

class FightLogger
{
    private $em;
    private $character;
    private $monster;
    private $fightLog;
    private $result;

    public function __construct($em)
    {
        $this->em = $em;
        $this->fightLog = new FightLog();
    }

    public function setupLogFight(\Nexus\CoreBundle\Entity\Characters $character, \Nexus\CoreBundle\Entity\Monster $monster) {
    	$this->character = $character;
        $this->monster = $monster;
        
        $this->fightLog->setCharacter($this->character); // Link log with current character
        $this->fightLog->setMonster($this->monster); // Link log with current monster
        $this->fightLog->setMonsterType($this->monster->getType()); // Set monster type
        $this->fightLog->setMonsterExperienceReward($this->monster->getExperienceReward()); // Set monster experience rewad
        $this->fightLog->setMonsterLevel($this->monster->getLevel()); // Set monster level
        $this->fightLog->setCharacterLevel($this->character->getLevel()); // Set character level before fightLog
        $this->fightLog->setCharacterStartHealth($this->character->getHealth()); // Set character health before fightLog
        $this->fightLog->setMonsterStartHealth($this->monster->getHealth()); // Set monster health before fightLog
    }

    public function finishLogFight() {
        if ($this->monster->getHealth() <= 0) { // Fight win
            $this->fightLog->setResult(true);
        } else {                                // Fight lose
            $this->fightLog->setResult(false);
        }

        $this->fightLog->setCharacterLevelFinal($this->character->getLevel()); // Set character level after fightLog
        $this->fightLog->setDamageDone($this->fightLog->getMonsterStartHealth() - $this->monster->getHealth()); // Damage done by character
        if ($this->character->getHealth() == 100) { // Character dead
            $this->fightLog->setDamageTaken($this->fightLog->getCharacterStartHealth()); // Damage taken == Character start health
        } else { // Character alive
            $this->fightLog->setDamageTaken($this->fightLog->getCharacterStartHealth() - $this->character->getHealth()); // Damage taken == Character start health - Current health
        }

        $this->save($this->fightLog); // Save Fight Log
    }

    public function getLastLogHTML() {
        $fightLog_rep = $this->em->getRepository('NexusCoreBundle:FightLog');

        $fightLogs = $fightLog_rep->getLastLog();

        foreach ($fightLogs as $fightLog) {
            $result = $fightLog->getCharacter()->getUser()->getUsername(). '(<strong>'.$fightLog->getCharacterLevel().'</strong>)';
            $result .= ($fightLog->getResult()) ? ' has won' : ' has lost';
            $result .= ' against '.$fightLog->getMonster()->getName().' (<strong>'.$fightLog->getMonsterLevel().'</strong>';
            $result .= ($fightLog->getMonsterType() == 1) ? ' / <strong>Normal</strong>)' : ' / <strong>Elite</strong>)';
            $this->result[] = $result;
            if ($fightLog->getCharacterLevel() != $fightLog->getCharacterLevelFinal()) {
                $result = $fightLog->getCharacter()->getUser()->getUsername(). '(<strong>'.$fightLog->getCharacterLevel().'</strong>)';
                $result .= ($fightLog->getCharacterLevel() > $fightLog->getCharacterLevelFinal()) ?  ' has lost' : ' has gained';
                $result .= ' one level (<strong>'.$fightLog->getCharacterLevelFinal().'</strong>)';
                $this->result[] = $result;
            }
        }
        
        return $this->result;
    }

    public function getLastLog() {
        $fightLog_rep = $this->em->getRepository('NexusCoreBundle:FightLog');

        $fightLogs = $fightLog_rep->getLastLog();
        
        return $fightLogs;
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