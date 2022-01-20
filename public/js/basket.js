$(document).ready(function() {
    const steps = document.querySelectorAll('.cart-step-box');
});

function toStep(nbr) {
    for (let i = 1; i < 4; i++) {
        $('#step_'+i+' .content').hide("slow")
        $('#step_'+i).removeClass('done')
        $('#step_'+i).removeClass('active')
        $('#step_'+i).addClass('awaiting')
    }

    for (let i = nbr-1; i > 0; i--) {
        $('#step_'+i).removeClass('awaiting')
        $('#step_'+i).addClass('done')
    }

    $('#step_'+nbr+' .content').show("slow")
    $('#step_'+nbr).removeClass('awaiting')
    $('#step_'+nbr).addClass('active')
}