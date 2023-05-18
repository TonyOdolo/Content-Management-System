$(document).ready(function (){
    
// Checkbox
    $('#selectAllBoxes').click(function (event) {
        if (this.checked) {
            $('.checkBoxes').each(function () {
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function () {
                this.checked = false;
            });
        }
    });



    // Loader
    var div_box = "<div id ='load-screen'> <div id ='loading'></div></div>";
    $("body").prepend(div_box);
    $('#load-screen').delay(1000).fadeOut(500, function () {
        $(this).remove();
    });


});


function loadUsersOnline() {
    $.get("functions.php?usersonline=result", function (data) {
        $(".usersOnline").text(data);
    });
}
setInterval(function () {
    loadUsersOnline();
    
}, 500);

