<?php
if(strtotime($quizz['date_end']) < time()){ ?>
<h2 style="text-align:center">Résultats du quizz <?php echo $quizz['name'];?></h2><br>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Rang</th>
                <th>Nom</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 1;
                $topten = $results;
                if(count($topten)>10)
                    $topten = array_slice($topten,0,10);
                foreach($topten as $p){
                    echo '
                        <tr'.(($p['id_player'] == $idPlayer)? ' class="you"' : '' ).'>
                            <td'.(($i == 1)? ' id="first"' : '' ).'>'.$i.'</td>
                            <td>'.$p['first_name'].' '.$p['last_name'].'</td>
                            <td>'.$p['total'].'</td>
                        </tr>
                   ';
                    $i++;
                }
                if(!array_key_exists($idPlayer,$topten)){
                    $results = array_values($results);
                    $player = array_search($idPlayer,$results);
                    echo '
                        <tr><td colspan="3">...</td></tr>
                        <tr class="you">
                            <td>'.($player++).'</td>
                            <td>'.$results[$player]['first_name'].' '.$results[$player]['last_name'].'</td>
                            <td>'.$results[$player]['total'].'</td>
                        </tr>
                    ';
                }
            ?>
        </tbody>
    </table>
</div>
<?php }else{ ?>
<div class="container-fluid">
    <h3 style="text-align:center">Votre score pour le quizz <?php echo $quizz['name'];?> : <b><?php echo $myresults[$idPlayer]['total'];?></b></h3><br>
    Les résultats seront disponibles dès la fin du quizz, le <b><?php echo date('d/m/Y à H:i', strtotime($quizz['date_end']));?></b><br>
    Vous recevrez une notification pour vous prévenir de la publication des résultats et savoir si vous avez gagné <b><?php echo $quizz['lot']; ?></b>...
    Restez branchés !
</div>
<?php } ?>
<style>
    .you{
        background-color: chartreuse;
    }
    #first, #first + td, #first +td + td{
        color: crimson;
    }
    #first:after{
        content: "★";
    }
</style>