$(function() {
    $('#login').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "/login",
            method: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                console.log(data);
            }
        });
    });
});