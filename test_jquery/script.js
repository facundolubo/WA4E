//JQuery script
$(document).ready(function() {
    console.log("JQuery is working");
    $.getJSON('index.php', function (data) {
        $('#test').html(data);
        window.console.log(data);
    });
})
