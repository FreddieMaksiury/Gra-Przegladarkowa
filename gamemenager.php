<?php
require_once('Vilage.php');
require_once('Logclass.php');
class GameManager
{
    public $v; 
    public $l; 
    public $t; 

    public function __construct()
    {
        $this->l = new Log();
        $this->v = new Village($this);
        $this->l->log("Tworzę nową gre...", 'gameManager', 'info');
        $this->t = time();

    }
    public function deltaTime() : int
    {
        return time() - $this->t;
    }
    public function sync()
    {
        $this->v->gain($this->deltaTime());
        $this->t = time();
    }
}
?>