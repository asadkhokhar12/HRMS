
$('.lang-handler').on("click", function(){
    if(!$('.slider-cradle').hasClass('is-transitioned')){
        $('#flagImg').attr('src', '../../../public/images/flags/bn.png');

        changeLanguage("lang/bn");
    }else{
        $('#flagImg').attr('src', '../../../public/images/flags/en.png');
        changeLanguage("lang/en");
    }
    $('.slider-cradle').toggleClass('is-transitioned');
});


function changeLanguage(url) {
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            console.log(data);
            location.reload();
        },
        error: function (err) {
            console.log(err);
        }
    });
}
