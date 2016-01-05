
<div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-3" style="text-align:center">
            <p style="font-size: 40px;">1</p>
            <p>Création du Quizz</p>
        </div>
        <div class="col-md-3" style="text-align:center;color:#d4d4d4">            
            <p style="font-size: 40px;">2</p>
            <p>Ajout des questions</p>
        </div>
        <div class="col-md-3"></div>
    </div>
    <hr>
    <div class="row" id="title">
        <div class="col-md-12">
            <h4 style="text-align:center">Ajout d'un nouveau Quizz !</h4>
        </div>
    </div>
    <form action="" method="POST">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="quizz-name">Nom du quizz</label>
                    <input type="text" class="form-control" id="quizz-name" name="quizz-name" placeholder="Nom" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="quizz-start-datetime">Date de début</label>
                    <div class="input-append date">
                        <input size="16" type="text" value="" name="quizz-start-datetime" id="quizz-start-datetime" readonly class="form-control form_datetime" placeholder="Cliquer pour ouvrir le calendrier..." required>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="quizz-end-datetime">Date de fin</label>
                    <div class="input-append date">
                        <input size="16" type="text" value="" name="quizz-end-datetime" id="quizz-end-datetime" readonly class="form-control form_datetime" placeholder="Cliquer pour ouvrir le calendrier..." required>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="nbQuestions">Nombre de questions</label>
                    <input type="number" class="form-control" min="1" max="15" value="10" name="quizz-nbQuestions" id="nbQuestions" required>
                </div>

            </div>
            <div class="col-md-1">
                <br>
                <button type="submit" name="submit" class="btn btn-link"><i class="fa fa-arrow-circle-right" style="font-size:30px"></i></button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        //configurations générales des 2 datetimepicker
        $(".form_datetime").datetimepicker({
            format: "dd/mm/yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            weekStart: 1,
            startDate: new Date(),
            todayHighlight: false,
            minuteStep: 5
        });
        //configuration du 1er datetimepicker
        $('#quizz-start-datetime').datetimepicker().on('changeDate', function(ev){
            $('#quizz-end-datetime').datetimepicker('setStartDate', ev.date);
        });
        //configuration du 2ème datetimepicker
        $('#quizz-end-datetime').datetimepicker().on('changeDate', function(ev){

        });

        //quand on remplie un champ
        $('#quizz-name, #quizz-start-datetime, #quizz-end-datetime').change(function(){
            $(this).css('border', '1px solid #CCC');
        });

        //vérification JS du formulaire
        $('form').submit(function(){
            //check si le nom du quizz n'est pas vide
            if($('#quizz-name').val().trim() == ''){
                $('#quizz-name').css('border', '1px solid #F00');
                $('#quizz-name').attr('placeholder', 'Veuillez saisir un nom');
                return false;
            };
            //check is la date du début n'est pas vide
            if($('#quizz-start-datetime').val().trim() == ''){
                $('#quizz-start-datetime').css('border', '1px solid #F00');
                $('#quizz-start-datetime').attr('placeholder', 'Veuillez saisir un nom');
                return false;
            }
            //check is la date de fin n'est pas vide
            if($('#quizz-end-datetime').val().trim() == ''){
                $('#quizz-end-datetime').css('border', '1px solid #F00');
                $('#quizz-end-datetime').attr('placeholder', 'Veuillez saisir un nom');
                return false;
            }

            return true;
        });
    });
</script>