/**
 * Created by Nasir on 11/10/2017.
 */


/*

document.addEventListener('DOMContentLoaded', function() {

    var elems = document.querySelectorAll('span.vehicle-ico1,span.vehicle-ico2,span.vehicle-ico3');
    for ( var i=0; i<elems.length; i++ )
    {
        elems[i].addEventListener('click', function () {
            if (this.classList.contains('active'))
                this.classList.remove('active');
            else {
                var spans=this.closest('div').querySelectorAll('span');
                for(var j=0; j < spans.length; j++)
                    spans[j].classList.remove('active');
                this.classList.add('active');
            }
        });
    }

});

*/



$(document).ready(function() {

    getList();
    showToRegion();

    $('form.form-horizontal').ajaxForm({
        dataType:  'json',
        beforeSubmit:  preRequest,
        success:   processJson
    });
});


function getList(){

    $.post( "/ajax.php?action=getList",{  } , function( data ) {
        $( "#tbody" ).html( data.content );
    },"json");
}

function checkNoTaxi()
{
    if ( $('.types-area span.vehicle-ico1').hasClass('active') )
        $('.no-taxi').fadeOut();
    else
        $('.no-taxi').fadeIn();
}


$(document).on('click','span.vehicle-ico1,span.vehicle-ico2,span.vehicle-ico3',function(){

    var icObj = $(this).parents('div');

    $('input[name="type"]').val('');

    if ($(this).hasClass('active'))
        $(this).removeClass('active');
    else {
        icObj.find('span').removeClass('active');
        $(this).addClass('active');
        $('input[name="type"]').val($(this).data('val'));
    }

    checkNoTaxi();

});


function showToRegion()
{
    if( $('select[name="regiontype"]').val()== 2 )
        $('select[name="toregion"]').fadeIn();
    else
        $('select[name="toregion"]').fadeOut();
}

$(document).on('change','select[name="regiontype"]',function(){
    showToRegion();
});



function preRequest () {

    $('.loading-overlay').show(); $('.close-form').hide();

    $('.has-error').removeClass('has-error');
    message(" <span style='color:#084ba0'>Müraciət icra olunur...</span>");

};

function processJson(data) {

    $('.loading-overlay').hide();  $('.close-form').show();

    if (data.code == 1) {
           color='green';
           resetForm();
            //getAppeals(data.id);
    }
    else {
        color='red';

        if (!jQuery.isEmptyObject(data.errorParams))
        {
            $.each(data.errorParams, function(element, error) {
                $('[name="' + element + '"]').parents('.form-group').addClass('has-error');
            });
        }
        else {
            $('[name="' + data.param + '"]').parents('.form-group').addClass('has-error');
        }
    }

    message('<span style="color:'+color+'">'+data.content+'</span>');
}


function resetForm() {
    $("form").trigger('reset');
    $('form').find('span.vehicle-ico1,span.vehicle-ico2,span.vehicle-ico3').removeClass('active');
    showToRegion();
    checkNoTaxi();
}


function message(msg)
{
    $('.message-box').html(msg);
}



function changeFormStatus()
{
    if (!$('form.vehicle-form').is(':visible')) {
        $('form.vehicle-form').slideDown(function(){
            $('html,body').animate({
                    scrollTop: $('form.vehicle-form').offset().top},
                'fast');
        });
    }
    else
    {
        $('form.vehicle-form').slideUp();
    }
}



$(document).on('click','.add-vehicle',function(){
    resetForm();
    if ($('form.vehicle-form').is(':visible')) return false;
    changeFormStatus();
});


$(document).on('click','.edit-vehicle',function(){
    id=$(this).parents('tr').data('id');
    //getVehicles(id);
    if ($('form.vehicle-form').is(':visible')) return false;
    changeFormStatus();
});


$(document).on('click','.close-form',function(){  changeFormStatus(); });
