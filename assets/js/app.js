require('../css/global.scss');
require('bootstrap');

// require jQuery normally
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

$(document).ready(function(){
    $(".card").slice(0, 3).show();

    console.log($(".card").slice(0, 3).show());
    $("#loadMore").on("click", function(e){
        e.preventDefault();
        $(".card:hidden").slice(0, 3).slideDown();
        if($(".card:hidden").length == 0) {
            $("#loadMore").css("display", "none");
        }
    });
})

$(document).ready(function(){
    $(".media").slice(0, 10).show();

    console.log($(".media").slice(0, 10).show());
    $("#loadMoreComment").on("click", function(e){
        e.preventDefault();
        $(".media:hidden").slice(0, 10).slideDown();
        if($(".media:hidden").length == 0) {
            $("#loadMoreComment").css("display", "none");
        }
    });
})