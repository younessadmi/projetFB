<?php if(count($players) > 0){?>
<div class="table-responsive">
    <table class="table table-bordered tablesorter">
        <thead>
            <tr>
                <th>Type</th>
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Age</th>
                <th>Sexe</th>
                <th>Lieu</th>
                <th>Email</th>
                <th>Appareils</th>
                <th>Applications</th>
                <th>Livres favoris</th>
                <th>Artistes favoris</th>
                <th>Athlètes favoris</th>
                <th>Profil</th>
            </tr>
        </thead>
        <tbody>
            <?php
    foreach($players as $p){
        echo '
            <tr>
                <td>'.(($p['is_admin'])? 'Admin' : 'User' ).'</td>
                <td>'.$p['id'].'</td>
                <td>'.$p['first_name'].' '.$p['last_name'].'</td>
                <td>'.$p['birthday'].'</td>
                <td>'.$p['gender'].'</td>
                <td>'.$p['location'].'</td>
                <td>'.$p['email'].'</td>
                <td>'.$p['devices'].'</td>
                <td>'.$p['application'].'</td>
                <td>'.$p['books'].'</td>
                <td>'.$p['music'].'</td>
                <td>'.$p['favorite_athletes'].'</td>
                <td><a href="http://www.facebook.com/'.$p['id_fb'].'" target="_blank">Voir le profil</a></td>
            </tr>
       ';
    }
            ?>
        </tbody>
    </table>
</div>
<?php }else{?>
<h3 style="text-align:center">Aucun joueur trouvé !</h3>
<?php }?>
<style>
    tr * {
        text-align:center;
    }
</style>


<script>
    $(function(){
        $(".tablesorter").tablesorter();
    });
</script>