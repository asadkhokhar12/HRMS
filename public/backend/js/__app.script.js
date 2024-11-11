"use strict";

$(document).ready(function () {
    $('.buttons-colvis').html('<i class="fas fa-columns" style="color:#27a580"></i>');
    $('.buttons-colvis').css('background-color', 'rgba(60, 210, 164,.5) !important');
});


$(document).ready(function() {
    function currentTime() {
        let date = new Date();
        let hh = date.getHours();
        let mm = date.getMinutes();
        let ss = date.getSeconds();
        let session = "AM";

        if(hh === 0){
            hh = 12;
        }
        if(hh == 12){
            session = "PM";
        }
        if(hh > 12){
            hh = hh - 12;
            session = "PM";
        }

        hh = (hh < 10) ? "0" + hh : hh;
        mm = (mm < 10) ? "0" + mm : mm;
        ss = (ss < 10) ? "0" + ss : ss;

        let time = hh + ":" + mm + ":" + ss + " " + session;
        $('.clock').html(time);
        // document.getElementById("clock").innerText = time;
        let t = setTimeout(function(){ currentTime() }, 1000);
    }
   currentTime();
});