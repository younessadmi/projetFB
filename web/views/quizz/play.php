<section id="quizz" data-id-quizz="<?php echo $this->registry->router->args[0];?>">
    <div data-id-fb="<?php echo $idFb;?>" style="display:none"></div>
    <div id="countdown"></div>
    <div id="number-question-status"></div>
    <div id="question" data-id-question=""></div>
    <ol id="reponses">
        <li class="reponse"><button data-nb="1" data-state="false" type="button" class="btn btn-default" data-id-proposition=""></button></li>
        <li class="reponse"><button data-nb="2" data-state="false" type="button" class="btn btn-default" data-id-proposition=""></button></li>
        <li class="reponse"><button data-nb="3" data-state="false" type="button" class="btn btn-default" data-id-proposition=""></button></li>
        <li class="reponse"><button data-nb="4" data-state="false" type="button" class="btn btn-default" data-id-proposition=""></button></li>
    </ol>
</section>

<style>
    /* temporaire avant qu'Axel fasse les modif*/
    section#quizz{
        background-color: #eee;
        width: 60%;
        margin-left: 20%;
        margin-right: 20%;
        padding: 10px;
        display: none;
    }
    div#question{
        text-align: center;
        font-weight: bold;
        margin-bottom:30px;
    }
    ol#reponses li.reponse button{
        width:100%;
    }
</style>


<script>
    $(document).ready(function(){
        //Si le quizz n'a jamais été fait
        var quizz = undefined;
        var welcome_message = "<p>Bienvenue sur le quizz <b><?php echo htmlentities($quizz['name']);?></b> !</p><p>Répondez correctement aux <b><?php echo htmlentities($quizz['questions_nb_displayed']);?></b> questions en un minimum de temps pour tenter de remporter <b>\"<?php echo htmlentities($quizz['lot']);?>\"</b> !</p><p>Bonne chance, et que le meilleur gagne !</p>";
        var availability = "<i class='fa fa-calendar'></i> <b><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $quizz['date_start'])->format('d/m/Y H:i:s');?></b> <i class='fa fa-chevron-right'></i> <b><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $quizz['date_end'])->format('d/m/Y H:i:s');?></b>";
        swal({
            title: "<?php echo htmlentities($quizz['name']);?>",
            text: "<div><p><?php echo htmlentities($quizz['description']);?></p><br><p>"+welcome_message+"</p><br><p></p><p style='font-style:italic;font-size:14px'>"+availability+"</p></div>",
            showCancelButton: true,
            confirmButtonText: "Charger le quizz",
            cancelButtonText: "Retour",
            closeOnConfirm: false,
            closeOnCancel: false,
            allowEscapeKey: false,
            html: true,
            showLoaderOnConfirm: true,
            imageUrl: "<?php echo BASE_URL.'img/quizz-main-picture/'.htmlentities($quizz['img']); ?>"
        }, function(isConfirm){
            if(isConfirm){
                //lancer le quizz
                $.ajax({
                    url: base_url+'ajax/getQuizzById',
                    method: 'POST',
                    data: { id: '<?php echo $this->registry->router->args[0];?>' },
                    dataType: 'JSON'
                }).done(function(data, textStatus, jqXHR){
                    swal({
                        title: "Quizz chargé !",
                        text: "Le quizz a été correctement chargé. Cliquer sur \"Commencer\" pour démarrer le quizz et lancer le compte à rebours",
                        type: "success",
                        confirmButtonText: "Commencer",
                        allowEscapeKey: false,
                        closeOnConfirm: true
                    },function(){
                        window.onbeforeunload = function(){ return "Attention, si vous quittez la partie, vous confirmez déclarer forfait et obtiendrez 0 pour ce quizz."};
                        launchQuizz(data.quizz);
                    });
                }).fail(function(jqXHR, textStatus, errorThrown){
                    console.error("{"+jqXHR.responseText+"}");
                    console.error(textStatus);
                    console.error(errorThrown);
                });

            }else{
                //redirection vers la page d'accueil
                NProgress.start();
                document.location.href = base_url;
            }
        });
    });
</script>
