/**
 * Created by Nasir on 11/10/2017.
 */


$(document).on('click','tbody tr span.vehicle-ico1,tbody tr span.vehicle-ico2,tbody tr span.vehicle-ico3',function(){

    if ($(this).hasClass('active'))
        $(this).removeClass('active');
    else {
        $(this).parents('td').find('span').removeClass('active');
        $(this).addClass('active');
    }

});
