<?php
class Village 
{
    private $gm;
    private $buildings;
    private $storage;
    private $upgradeCost;

    public function __construct($gameManger)
    {
        $this->gm = $gameManger;
        $this->log('Utworzono nową wioskę', 'info');
        $this->buildings = array(
            'townHall' => 1,
            'Tartaki' => 1,
            'Kamieniołom' => 1,
        );
        $this->storage = array(
            'Drewno' => 0,
            'Kamień' => 0,
        );
        $this->upgradeCost = array( 
            'Tartaki' => array(
                2 => array(
                    'Drewno' => 100,
                    'Kamień' => 50,
                ),
                3 => array(
                    'Drewno' => 200,
                    'Kamień' => 100,
                )
            ),
            'Kamieniołom' => array(
                1 => array(
                    'Drewno' => 100,
                ),
                2 => array(
                    'Drewno' => 300,
                    'Kamień' => 100,
                )
            ),
        );
    }
    private function woodGain(int $deltaTime) : float
    {
        
        $gain = pow($this->buildings['Tartaki'],2) * 10000;
        $perSecondGain = $gain / 3600;
        return $perSecondGain * $deltaTime;
    }
    private function ironGain(int $deltaTime) : float
    {
        $gain = pow($this->buildings['Kamieniołom'],2) * 5000;
        $perSecondGain = $gain / 3600;
        return $perSecondGain * $deltaTime;
    }
    public function gain($deltaTime) 
    {
        $this->storage['Drewno'] += $this->woodGain($deltaTime);
        if($this->storage['Drewno'] > $this->capacity('Drewno'))
            $this->storage['Drewno'] = $this->capacity('Drewno');

        $this->storage['Kamień'] += $this->ironGain($deltaTime);
        if($this->storage['Kamień'] > $this->capacity('Kamień'))
            $this->storage['Kamień'] = $this->capacity('Kamień');
    }
    public function upgradeBuilding(string $buildingName) : bool
    {
        $currentLVL = $this->buildings[$buildingName];
        $cost = $this->upgradeCost[$buildingName][$currentLVL+1];
        foreach ($cost as $key => $value) {
            if($value > $this->storage[$key])
                return false;
        }
        foreach ($cost as $key => $value) {
            $this->storage[$key] -= $value;
        }
        $this->buildings[$buildingName] += 1; 
        return true;
    }
    public function checkBuildingUpgrade(string $buildingName) : bool
    {
        $currentLVL = $this->buildings[$buildingName];
        $cost = $this->upgradeCost[$buildingName][$currentLVL+1];
        foreach ($cost as $key => $value) {
            if($value > $this->storage[$key])
                return false;
        }
        return true;
    }
    public function showHourGain(string $resource) : string
    {
        switch($resource) {
            case 'Drewno':
                return $this->woodGain(3600);
            break;
            case 'Kamień':
                return $this->ironGain(3600);
            break;
            default:
                echo "Nie ma takiego surowca!";
            break;
        }
    }
    public function showStorage(string $resource) : string 
    {
        if(isset($this->storage[$resource]))
        {
            return floor($this->storage[$resource]);
        }
        else
        {
            return "Nie ma takiego surowca!";
        }
    }
    public function buildingLVL(string $building) : int 
    {
        return $this->buildings[$building];
    }
    public function capacity(string $resource) : int 
    {
        switch ($resource) {
            case 'Drewno':
                return $this->woodGain(60*60*24);
                break;
            case 'Kamień':
                return $this->ironGain(60*60*12);
                break;
                
            default:
                return 0;
                break;
        }
    }
    public function log(string $message, string $type)
    {
        $this->gm->l->log($message, 'village', $type);
    }
}
?>