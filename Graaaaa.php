<?php 
        require_once('gamemenager.php');
        session_start();
        if(!isset($_SESSION['gm'])) 
        {
            $gm = new GameManager();
            $_SESSION['gm'] = $gm;
        } 
        else 
        {
            $gm = $_SESSION['gm'];
        }
        $v = $gm->v; 
        $gm->sync(); 
        
        if(isset($_REQUEST['action'])) 
        {
            switch($_REQUEST['action'])
            {
                case 'upgradeBuilding':
                    if($v->upgradeBuilding($_REQUEST['building']))
                    {
                        echo "Budynek został ulepszony: ".$_REQUEST['building'];
                    }
                    else
                    {
                        echo "Budynek nie został ulepszony: ".$_REQUEST['building'];
                    }
                    
                break;
                default:
                    echo 'Nieprawidłowa zmienna "action"';
            }
        }




        
        
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <header class="row border-bottom">
            <div class="col-12 col-md-3">
                Informacje o graczu
            </div>
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-md-3">
                        Kamień: <?php echo $v->showStorage("Kamień"); ?>
                    </div>
                    <div class="col-12 col-md-3">
                        Drewno: <?php echo $v->showStorage("Drewno"); ?>
                    </div>
                    <div class="col-12 col-md-3">
                        Zasób 3
                    </div>
                    <div class="col-12 col-md-3">
                        Zasób 4
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                 wyloguj
            </div>
        </header>
        <main class="row border-bottom">
            <div class="col-12 col-md-3 border-right">
                Lista budynków<br>
                Tartaki, poziom <?php echo $v->buildingLVL("Kamieniołom"); ?> <br>
                Zysk/h: <?php echo $v->showHourGain("Drewno"); ?><br>
                <?php if($v->checkBuildingUpgrade("Tartaki")) : ?>
                <a href="Graaaaa.php?action=upgradeBuilding&building=Tartaki">
                    <button>Ulepsz Tartaki</button>
                </a><br>
                <?php else : ?>
                    <button onclick="missingResourcesPopup()">Ulepsz Tartaki</button><br>
                <?php endif; ?>
                Kamieniołom, poziom <?php echo $v->buildingLVL("Kamieniołom"); ?> <br>
                Zysk/h: <?php echo $v->showHourGain("Kamień"); ?><br>
                <?php if($v->checkBuildingUpgrade("Kamieniołom")) : ?>
                <a href="Graaaaa.php?action=upgradeBuilding&building=Kamieniołom">
                    <button>Ulepsz Kamieniołom</button>
                </a>
                <?php else : ?>
                    <button onclick="missingResourcesPopup()">Ulepsz Kamieniołom</button>
                <br>
                <?php endif; ?>
            </div>
            <div class="col-12 col-md-6">
                Widok wioski
            </div>
            <div class="col-12 col-md-3 border-left">
                Wojsko
            </div>
        </main>
        <footer class="row">
            <div class="col-12">
            <table class="table table-bordered">
            <?php
            
                
                    
                
            
            foreach ($gm->l->getLog() as $entry) {
                $timestamp = date('d.m.Y H:i:s', $entry['timestamp']);
                $sender = $entry['sender'];
                $message = $entry['message'];
                $type = $entry['type'];
                echo "<tr>";
                echo "<td>$timestamp</td>";
                echo "<td>$sender</td>";
                echo "<td>$message</td>";
                echo "<td>$type</td>";
                echo "</tr>";
            }
            
            ?>
            </table>
            </div>
        </footer>
    </div>
    <script>
        function missingResourcesPopup() {
            window.alert("Brakuje zasobów");
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>