

/*=====================
  timer js
 ==========================*/


"use strict";
$(document).ready(function(){

 //    Set the date we're counting down to

var countDownDate1 = new Date("Oct 19, 2022 12:25:25").getTime();
var countDownDate2 = new Date("Sep 19, 2022 12:25:25").getTime();

var timer1 = document.getElementById("timer")
var timer2 = document.getElementById("timer2")

function countdown(finish_date, timer) {

  var x = setInterval(function() {

    var now = new Date().getTime();

    var distance = finish_date - now;

    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    timer.innerHTML = "<span>" + days + "<span class='padding-l'>:</span><span class='timer-cal'>Days</span></span>" + "<span>" + hours + "<span class='padding-l'>:</span><span class='timer-cal'>Hrs</span></span>"
            + "<span>" + minutes + "<span class='padding-l'>:</span><span class='timer-cal'>Min</span></span>" + "<span>" + seconds + "<span class='timer-cal'>Sec</span></span> ";


    if (distance < 0) {
      clearInterval(x);
      timer.innerHTML = "EXPIRED";
    }
  }, 1000);
}

countdown(countDownDate1, timer)
countdown(countDownDate2, timer2)

});