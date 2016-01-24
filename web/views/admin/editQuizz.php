<div>
    <div class="row">
        <div class="col-md-2">
            <a href="<?php echo BASE_URL;?>admin/listQuizz"><i class="fa fa-arrow-left"></i> Revenir à la liste des quizz</a>
        </div>
    </div>
    <h1 style="text-align:center">Mode édition</h1>
    <h3 style="text-align:center">Informations générales</h3>
    <form method="post" action="">
        <div class="row">
            <div class="col-md-2">
                <p>EN LIGNE</p>
            </div>
            <div class="col-md-10">
                <input type="checkbox" <?php echo (($quizz['enabled'])? 'checked':'');?> name="enabled" value="1">
            </div>
        </div>
<!--        <div class="row">-->
<!--            <div class="col-md-2">-->
<!--                <p>IDENTIFIANT</p>-->
<!--            </div>-->
<!--            <div class="col-md-10">-->
<!--                <input type="text" class="form-control" value="<?php echo $quizz['id'];?>" disabled>-->
                <input type="hidden" value="<?php echo $quizz['id'];?>" name="idquizz" hidden>
<!--            </div>-->
<!--        </div>-->
        <div class="row">
            <div class="col-md-2">
                <p>INTITULÉ DU QUIZZ</p>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control" value="<?php echo $quizz['name'];?>" name="name" required>
                <input type="hidden" value="<?php echo $quizz['name'];?>" name="original-name" hidden>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <p>DATE DE DÉBUT</p>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control form-datetime" value="<?php echo $quizz['date_start'];?>" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <p>DATE DE FIN</p>
            </div>
            <div class="col-md-10">
                <input type="text" class="form-control form-datetime" value="<?php echo $quizz['date_end'];?>" disabled>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <p>QUESTIONS AFFICHÉES</p>
            </div>
            <div class="col-md-10">
                <input type="number" min="1" max="<?php echo $quizz['questions_nb_total'];?>" class="form-control" value="<?php echo $quizz['questions_nb_displayed'];?>" name="questions_nb_displayed" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <p>TOTAL DE QUESTIONS</p>
            </div>
            <div class="col-md-10">
                <input type="number" value="<?php echo $quizz['questions_nb_total'];?>" class="form-control" disabled>
                <input type="hidden" name="questions_nb_total" value="<?php echo $quizz['questions_nb_total'];?>" hidden>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-10">
                <button type="submit" class="btn btn-success" name="submit">METTRE A JOUR</button>
            </div>
        </div>
    </form>
    <h3 style="text-align:center">Questions / Réponses</h3>
</div>
<style>
    .row{
        margin-bottom: 10px
    }
</style>