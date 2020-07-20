/*--------------------BOTTONE JOIN--------------------*/
$(document).ready(function () {
    $(document).on("click", "#join", function (event) {    
        event.preventDefault();
        var join = $(this).val();
        console.log(join);

        /*
        $.ajax({
            url: `enters/store`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'url': join
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                console.log(error, 'error on item to add');
            }
        });
        */
        $(this).prop('disabled', true);
    });
})

