<h2 style="text-align:center">Liste des utilisateurs</h2><br>
<?php if(count($players) > 0){?>
<div class="table-responsive">
    <table class="table table-bordered tablesorter">
        <thead>
            <tr>
                <th>Type</th>
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Age</th>
                <th>Genre</th>
                <th>Lieu</th>
                <th>Email</th>
                <th>Appareils</th>
                <th>Applications</th>
                <th>Livres favoris</th>
                <th>Artistes favoris</th>
                <th>Athlètes favoris</th>
                <th>Dernière connexion</th>
            </tr>
        </thead>
        <tbody>
            <?php
    foreach($players as $p){
        echo '
            <tr>
                <td>'.(($p['is_admin'])? 'Admin' : 'User' ).'</td>
                <td>'.$p['id'].'</td>
                <td><a href="http://www.facebook.com/'.$p['id_fb'].'" target="_blank">'.$p['first_name'].' '.$p['last_name'].'</a></td>
                <td>'.$p['birthday'].'</td>
                <td>'.$p['gender'].'</td>
                <td>'.$p['location'].'</td>
                <td>'.$p['email'].'</td>
                <td data-header="Appareils" data-sweet="'.$p['devices'].'"><a href="#">Afficher</a></td>
                <td data-header="Applications" data-sweet="'.$p['application'].'"><a href="#">Afficher</a></td>
                <td data-header="Livres" data-sweet="'.$p['books'].'"><a href="#">Afficher</a></td>
                <td data-header="Artistes favoris" data-sweet="'.$p['music'].'"><a href="#">Afficher</a></td>
                <td data-header="Athlètes favoris" data-sweet="'.$p['favorite_athletes'].'"><a href="#">Afficher</a></td>
                <td>'.date('d/m/Y',strtotime($p['last_update'])).'</td>
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
        $(".tablesorter").tablesorter({
            sortList: [[0,0]] 
        });
        
        $('td[data-sweet]').click(function(){
            var data = $(this).attr("data-sweet");
            var html = "<ul style='text-align:left'>";
            data = data.split('|');
            for(var i=0;i<data.length;i++)
            {
                html += "<li>"+data[i]+"</li>";
            }
            html += "</ul>";
            swal({
                title: $(this).attr("data-header"),
                text: html,
                html: true
            });
        });
    });
</script>