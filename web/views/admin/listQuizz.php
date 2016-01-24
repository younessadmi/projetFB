<div class="table-responsive">
    <table class="table table-bordered tablesorter">
        <thead>
            <tr>
                <th>Etat</th>
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Nombre de questions affichées</th>
                <th>Nombre de questions totales</th>
                <th>Editer</th>
            </tr>
        </thead>
        <tbody>
            <?php
foreach($quizz as $q){
    echo '
            <tr '.((!$q['enabled'])? 'class=warning' : '' ).'>
                <td>'.(($q['enabled'])? 'Activé' : 'Désactivé' ).'</td>
                <td>'.$q['id'].'</td>
                <td>'.$q['name'].'</td>
                <td>'.$q['date_start'].'</td>
                <td>'.$q['date_end'].'</td>
                <td>'.$q['questions_nb_displayed'].'</td>
                <td>'.$q['questions_nb_total'].'</td>
                <td><a href="'.BASE_URL.'admin/editQuizz/'.$q['id'].'"><i class="fa fa-pencil-square-o"></i></a></td>
            </tr>
       ';
}
            ?>
        </tbody>
    </table>
</div>
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