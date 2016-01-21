<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Etat</th>
                <th>Nombre de questions affichées</th>
                <th>Nombre de questions totales</th>
                <th>Editer</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($quizz as $q){
                   echo '
                        <tr>
                            <td>'.$q['id'].'</td>
                            <td>'.$q['name'].'</td>
                            <td>'.$q['date_start'].'</td>
                            <td>'.$q['date_end'].'</td>
                            <td>'.$q['enabled'].'</td>
                            <td>'.$q['questions_nb_displayed'].'</td>
                            <td>'.$q['questions_nb_total'].'</td>
                            <td><i class="fa fa-pencil-square-o"></i></td>
                            <td><i class="fa fa-trash"></i></td>
                        </tr>
                   ';
                }
            ?>
        </tbody>
    </table>
</div>
<style>
    td {
        text-align:center;   
    }
</style>