<div class="row">
    <?php foreach($quizz as $quiz){?>
    <?php if($quiz['enabled']){?>
    <div class="col-md-4 <?php echo (strtotime($quiz['date_end']) < time())?'quizz-disabled':'';?>" style="padding:5px; box-shadow: 1px 1px 10px rgba(183, 87, 255, 0.5); border-radius:5px">
        <div style="background:#b757ff;">
            <img src="<?php echo BASE_URL.'img'.DIRECTORY_SEPARATOR.'quizz-main-picture'.DIRECTORY_SEPARATOR.$quiz['img'];?>" alt="" style="display: block;margin-left: auto;margin-right: auto;padding-top:5px; height:100px">
            <hr class="style-eight">
            <p style="text-align:center"><?php echo htmlentities($quiz['name']);?></p>
        </div>
        <div class="row">
            <div class="col-md-8">
                <a href="<?php echo BASE_URL;?>quizz/play/<?php echo $quiz['id'] ?>">
                    <button type="button" class="btn btn-default" style="width:100%">Jouer <i class="fa fa-chevron-right"></i></button>
                </a>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-link" style="width:100%">???????</button>
            </div>
        </div>
    </div>
    <?php }?>
    <?php }?>
</div>

<style>

</style>