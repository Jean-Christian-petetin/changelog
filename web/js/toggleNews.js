//var acc = document.getElementsByClassName("toggle");
//var i;
//
//for (i = 0; i < acc.length; i++) {
//    acc[i].onclick = function(){
//        this.classList.toggle("active");
//        this.nextElementSibling.classList.toggle("show");
//    };
//}

$(document).ready(function(){
    $("button").click(function(){
        $(this).toggleClass("active");
        $(this).next().toggleClass("show");
    });
});