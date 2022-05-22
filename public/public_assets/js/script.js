// Loading Animation & Search bar Animation
var headerMiddle = document.querySelector('.header-middle-inner');
window.addEventListener('load', (event) => {
    headerMiddle.classList.add('active');
});
// Loading Animation
$(window).load(function() {
    $('.loading-animation .content').on('animationiteration',function(){
        $('.loading-animation').addClass('loaded');
        setTimeout(function() {
            $('body').removeClass('loading');
        }, 600);
        
    })
});

// Search bar show
$('.top-cat-field').click(function(){
    if($('#search_bg').length <= 0){
        $("body").append('<div id="search_bg"></div>');
        $("body").addClass('loading');
        setTimeout(function() {
            $('#search_bg').addClass('active');
        }, 20);
    }
});

$(document).on('click','#search_bg',function(){
    $('.search_result_box').fadeOut(400);
    $('#search_bg').remove();
    $("body").removeClass('loading');
});


// Search bar
var select_value = $('#search_select').val();
$('#search_select').change(function(){
    var select_value = $('#search_select').val();
})
$('#search_input').keyup(function(){
    var input_value = $('#search_input').val();
    if(input_value.length > 0) {
        $('.search_result_box').fadeIn(400);
    }else {
        $('.search_result_box').fadeOut(400);
    }
});