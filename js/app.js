$(document).ready(function() {
    const divFrame = document.querySelector(".frame");
    $('.button').bind('click', () => {
        $('.modal').addClass('hide');
        divFrame.remove();
    });
});