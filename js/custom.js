/**
 * Created by Nasir on 11/10/2017.
 */

/*
$(document).on('click','tbody tr span.vehicle-ico1,tbody tr span.vehicle-ico2,tbody tr span.vehicle-ico3',function(){

    if ($(this).hasClass('active'))
        $(this).removeClass('active');
    else {
        $(this).parents('td').find('span').removeClass('active');
        $(this).addClass('active');
    }

});

    */

document.addEventListener('DOMContentLoaded', function() {

    var elems = document.querySelectorAll('tbody tr span.vehicle-ico1,tbody tr span.vehicle-ico2,tbody tr span.vehicle-ico3');

    for ( var i=0; i<elems.length; i++ )
    {
        elems[i].addEventListener('click', function () {

            if (this.classList.contains('active'))
                this.classList.remove('active');
            else {

                 var spans=this.closest('td').querySelectorAll('span');
                 for(var j=0; j < spans.length; j++)
                     spans[j].classList.remove('active');
                 this.classList.add('active');
            }
        });
    }
});




