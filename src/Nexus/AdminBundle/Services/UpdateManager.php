<?php

namespace Nexus\AdminBundle\Services;
use Nexus\CoreBundle\Entity\WeeklyUpdate;
use Nexus\CoreBundle\Entity\Characters;

class UpdateManager
{
    private $em;
    private $validator;
    private $xml;
    private $weeklyUpdate;
    private $character;
    private $result;


    public function __construct($em, $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->update_rep = $this->em->getRepository('NexusCoreBundle:WeeklyUpdate');
    }

	public function moveFile($files) {
        $files = $files;
        foreach ($files as $file) {
            $file = $file['file'];
        }
        $dir = __DIR__.'/../Resources/public/xml';
        $file->move($dir, 'Nexus.xml');
	}

	public function parseFile() {
		$dir = __DIR__.'/../Resources/public/xml';
		$this->xml = simplexml_load_file($dir.'/Nexus.xml');
		if ($this->xml) {
			foreach ($this->xml->record as $update) {

				$this->character = $this->em->getRepository('NexusCoreBundle:Characters')->find($update->char_id);
				if (!$this->character) {
	                $this->result['status'] = "error";
	                $this->result['info']['message'] = "Wrong or empty character ID: ".$update->char_id."<br/>";
	                break;
                } else {
                    $this->doUpdate($update);
                    $this->checkUpdate();
                    if ($this->result['status'] == "error") {
                    	break;
                    }
                }
			}

		} else {
			$this->result['status'] = "error";
			$this->result['info']['message'] = "Unable to read the file.";
		}

		if ($this->result['status'] == "success") {
			$this->flush();
		}
		return $this->result;
	}

	private function doUpdate($update) {
		$this->weeklyUpdate = new WeeklyUpdate;

		$this->weeklyUpdate->setExperience1($this->checkNode((string)$update->xp1));
		$this->weeklyUpdate->setExperience2($this->checkNode((string)$update->xp2));
		$this->weeklyUpdate->setDamage1($this->checkNode((string)$update->dmg1));
		$this->weeklyUpdate->setDamage2($this->checkNode((string)$update->dmg2));
		$this->weeklyUpdate->setArmor($this->checkNode((string)$update->armor));
		$this->weeklyUpdate->setResist($this->checkNode((string)$update->resist));
		$this->weeklyUpdate->setMitigation($this->checkNode((string)$update->mitigation));
		$this->weeklyUpdate->setAttackSpeed($this->checkNode((string)$update->as));
		$damageTaken = floor(((float)$update->dmg1+ $update->dmg2)*(1-(float)$update->mitigation));
		$this->weeklyUpdate->setHealthLost($damageTaken);

        $this->character->processDamageTaken($damageTaken);
        $this->character->setAttackSpeed((float)$update->as);
        $this->character->processExperienceGain((float)$update->xp1+(float)$update->xp2);
        $this->character->setFight(3);
        $power = 1 + ($this->character->getLevel() - 1)/10;
        $this->character->setPower($power);
        $this->character->addUpdate($this->weeklyUpdate);			
	}

	private function checkUpdate() {
        $errorList = $this->validator->validate($this->weeklyUpdate);
        if (count($errorList) > 0) {
            $this->result['status'] = "error";
            $this->result['info']['message'] = "";
            foreach ($errorList as $errors) {
                $this->result['info']['message'] .= '<strong>'.$errors->getPropertyPath().'</strong>: '.$errors->getMessage().' ('.$this->character->getName().')<br/>';
            }
        } else {
        	$this->persist($this->character);
            $this->result['status'] = "success";
            $this->result['info']['message'] = "The update has been made ​​successfully";	
        }
	}

    private function checkNode($node)
    {
        return (isset($node) && (!empty($node) || $node == '0')) ? $node : null;
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