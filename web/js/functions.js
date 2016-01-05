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