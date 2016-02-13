<?php if(!empty($quizz)){ 
    $nbQuizzEnabled = 0;
    foreach($quizz as $quiz){
        if($quiz['enabled']){
            $nbQuizzEnabled++;   
        }
    }
?>

<div class="row">
    <?php if($nbQuizzEnabled > 0){
        foreach($quizz as $quiz){
            if($quiz['enabled']){?>
    <div class="col-md-4 <?php echo (strtotime($quiz['date_end']) < time())?'quizz-disabled':'';?>" style="padding:5px; box-shadow: 1px 1px 10px rgba(183, 87, 255, 0.5); border-radius:5px">
        <div style="background:#b757ff;">
            <img src="https://www.facebook.com/<?php echo $quiz['img'];?>" alt="" style="display: block;margin-left: auto;margin-right: auto;padding-top:5px; height:100px">
            <hr class="style-eight">
            <p style="text-align:center;font-weight:bold" class="crop"><?php echo htmlentities($quiz['name']);?></p>
            <p style="text-align:center;font-style:italic;" class="crop"><?php echo (!empty(trim($quiz['description']))) ? htmlentities($quiz['description']) : 'Aucune description';?></p>
            <p style="text-align:center" class="crop"><i class="fa fa-trophy" style="font-size:20px"></i> <?php echo htmlentities($quiz['lot']);?></p>
        </div>
        <div class="row">
            <?php if($quiz['isAbleToPlay'] && strtotime($quiz['date_end']) > time()){?> 
            <div class="col-md-12">
                <a href="<?php echo BASE_URL;?>quizz/play/<?php echo $quiz['id'];?>">
                    <button type="button" class="btn btn-default" style="width:100%">
                        Jouer <i class="fa fa-chevron-right"></i>
                    </button>
                </a>
            </div>
            <?php }else{?>
            <div class="col-md-6">
                <a href="<?php echo BASE_URL;?>quizz/results/<?php echo $quiz['id'];?>">
                    <button type="button" class="btn btn-default" style="width:100%">
                        Scores <i class="fa fa-chevron-right"></i>
                    </button>
                </a>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-link" style="width:100%">
                    <?php echo (!$quiz['isAbleToPlay'])? $quiz['score'] : '';?>
                </button>
            </div>
            <?php }?>
        </div>
    </div>
    <?php }?>
    <?php }?>
    <?php }else{?>
    <h2 style="text-align:center">Aucun quizz n'est encore disponible ! Coming soon !</h2>
    <?php }?>
    <?php }else{?>
    <h2 style="text-align:center">Aucun quizz n'est encore disponible ! Coming soon !</h2>
    <?php }?>
</div>