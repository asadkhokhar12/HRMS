"use strict";

var _token = $('meta[name="csrf-token"]').attr('content');
var baseUrl = $('meta[name="base-url"]').attr('content');
$(function() {
    var header = $(".start-style");
    $(window).on("scroll",function() {    
        var scroll = $(window).scrollTop();
    
        if (scroll >= 10) {
            header.removeClass('start-style').addClass("scroll-on");
        } else {
            header.removeClass("scroll-on").addClass('start-style');
        }
    });
});		
    
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$('#leaveMessageBtn').on('click', function(){
    $(this).addClass('hide');
    $('.contact-form-wrapper').addClass('show');
})

$('#closeContactBox').on('click', function(){
    $('#quickContactForm').find("input[type=text], input[type=email], textarea").val("");
    $('#leaveMessageBtn').removeClass('hide');
    $('.contact-form-wrapper').removeClass('show');
})

$('#playPauseBtn').on('click', function() {

    const video = document.getElementById('awwVideo');

    if (video.paused) {
        $(this).html('<i class="fas fa-pause-circle e"></i>')
        $('.center-content').addClass('visible-will');
        video.play();
    } else {
        $(this).html('<i class="fas fa-play-circle e"></i>')
        $('.center-content').removeClass('visible-will');
        video.pause();
    }
})