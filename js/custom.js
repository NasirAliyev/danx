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

    setDatepicker();

});


function setDatepicker(){

    $('.datepicker').datepicker({
        format: 'yyyy.mm.dd',
        startDate: '-0d'
    });
}

function loadingTable()
{
    if ( $('.loader').size()>0 )
         $('.loader').remove();
    else
    {
        $( "#tbody" ).html('');
        $( ".table" ).after('<div class="loader">Yüklənir...</div>');
    }
}


function getList(){

    loadingTable();

    $.post( "/ajax.php?action=getList",{  } , function( data ) {
        loadingTable();
        $( "#tbody" ).html( data.content );
    },"json");
}

function checkNoTaxi()
{
    if ( $('.types-area span.vehicle-ico1').hasClass('active') )
        $('.no-taxi').hide();
    else
        $('.no-taxi').show();
}

function checkTypeOptions()
{

    var type = $('input[name="type"]').val();

    if (type == 3) $('.hideOnTruck').hide(); else $('.hideOnTruck').show();

    $('[name="regiontype"] option').show();
    $('[data-show]').hide();

    $('[data-show="ontype'+type+'"]').show();
    $('[data-hide="ontype'+type+'"]').hide();


    $('[name="regiontype"] option').each(function(){
        if($(this).css('display') != 'none'){
            $('[name="regiontype"]').val($(this).val());
            return false;
        }
    });

    showToRegion();


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
    checkTypeOptions();

});


function showToRegion()
{
    if( $('select[name="regiontype"]').val()== 2 )
        $('select[name="toregion"]').show();
    else
        $('select[name="toregion"]').hide();
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
           getList();
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
    $('form input[name="id"]').val('');
    $('form input[name="type"]').val('1');
    $('form').find('span.vehicle-ico1,span.vehicle-ico2,span.vehicle-ico3').removeClass('active');
    $('form').find('span.vehicle-ico1').addClass('active');
    checkNoTaxi();
    checkTypeOptions();
    $('.file-exists').html('');
    $('.warning-msg').html('').hide();
}


function message(msg)
{
    $('.message-box').html(msg);
}


function slideToForm(){
    $('form.vehicle-form').slideDown(function(){
        $('html,body').animate({
                scrollTop: $('.under-table').offset().top},
            'fast');
    });
}

function changeFormStatus()
{
    if (!$('form.vehicle-form').is(':visible')) {
       slideToForm();
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


$(document).on('click','.close-form',function(){  changeFormStatus(); });


$(document).on('click','a.edit-vehicle',function(){

    if (!$('form.vehicle-form').is(':visible'))
        changeFormStatus();
    else
        slideToForm();


    $('.loading-overlay').show();  $('.close-form').hide();
    var id = $(this).parents('tr').data('id');
    resetForm();
    message(" <span style='color:#084ba0'>Məlumat yüklənir...</span>");

    $.post( "/ajax.php?action=getVehicle",{ id:id } , function( data ) {

            $('.loading-overlay').hide();  $('.close-form').show();

            if (data.content.hasOwnProperty('id'))
            {
                /*
                Object.keys(data.content).forEach(function(key) {
                    if ( data.content[key] != null )
                        $('[name="'+key+'"]').val(data.content[key]);
                });
                */

                $('input[name="id"]').val(data.content.id);

                $('input[name="vehicle"]').val(data.content.vehicle);
                $('input[name="number"]').val(data.content.number);
                $('input[name="driver"]').val(data.content.driver);

                $('input[name="type"]').val(data.content.type);
                $('form').find('span.vehicle-ico1,span.vehicle-ico2,span.vehicle-ico3').removeClass('active');
                $('form span.vehicle-ico'+data.content.type).addClass('active');

                if (data.content.capacity != null)
                    $('input[name="capacity"]').val(data.content.capacity);


                $('input[name="months"]').val(data.content.months);
                $('select[name="regiontype"]').val(data.content.regiontype);
                $('select[name="region"]').val(data.content.region);

                $('input[name="fromdate"]').val(data.content.fromdate);

                 if (data.content.toregion != null)
                 $('select[name="toregion"]').val(data.content.toregion);


                $('form span.vehicle-ico'+data.content.type).addClass('active');
                setDatepicker();


                if (data.content.status == 3 && data.content.message.length > 0 )
                    $('.warning-msg').html(data.content.message).show();

                if (data.content.doc1_1 != null)
                $('input[name="doc1_1"]').parents('.controls').find('.file-exists').html('<a target="_blank" href="/upload/'+data.content.doc1_1+'">Fayla bax</a>');
                if (data.content.doc1_2 != null)
                $('input[name="doc1_2"]').parents('.controls').find('.file-exists').html('<a target="_blank" href="/upload/'+data.content.doc1_2+'">Fayla bax</a>');
                if (data.content.doc2_1 != null)
                $('input[name="doc2_1"]').parents('.controls').find('.file-exists').html('<a target="_blank" href="/upload/'+data.content.doc2_1+'">Fayla bax</a>');
                if (data.content.doc2_2 != null)
                $('input[name="doc2_2"]').parents('.controls').find('.file-exists').html('<a target="_blank" href="/upload/'+data.content.doc2_2+'">Fayla bax</a>');
                if (data.content.doc3 != null)
                $('input[name="doc3"]').parents('.controls').find('.file-exists').html('<a target="_blank" href="/upload/'+data.content.doc3+'">Fayla bax</a>');

                showToRegion();
                checkNoTaxi();
                message('');
            }
            else
                message(data.content);

        }
    ,"json");


});


$(document).on('click','img.ad-info-save',function() {

    $('.ad-info-status').html('icra olunur...');

    $.post("/ajax.php?action=userInfo", {email:$('input[name="email"]').val(),phone:$('input[name="phone"]').val()}, function (data) {

        if (data.code == 1)
            color='green';
        else
            color='red';

        $('.ad-info-status').html('<span style="color:'+color+'">'+data.content+'</span>');

    }, "json");

});


