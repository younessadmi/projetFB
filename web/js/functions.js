var base_url = '';

function setBaseUrl(url){
    base_url = url;   
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function printMessage(message, level){
    $('header').after('<div class="alert alert-'+level+' alert-dismissible fade in" style="display:none" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+htmlEntities(message)+'</div>');

    $('.alert').show('fast');
}

function updateQuestion(idQuestion, idPropositions, question){
    NProgress.start();
    $.ajax({
        url: base_url+'ajax/updateQuestion',
        method: 'POST',
        data: { idQuestion: idQuestion, idPropositions: idPropositions },
        dataType: 'JSON'
    }).done(function(data, textStatus, jqXHR){
        $('p#question_'+question).html(htmlEntities($("div[data-id-question='"+question+"'] input[data-id-question]").val()));
    }).fail(function(jqXHR, textStatus, errorThrown){
        console.error("{"+jqXHR.responseText+"}");
        console.error(textStatus);
        console.error(errorThrown);
    }).always(function(){
        NProgress.done();
    });
}