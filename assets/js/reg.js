$('#registration').submit(function(e){
    $(document).ready(function(){
        $('.form-control-feedback').text('');
    });                
    e.preventDefault();

    var data = new FormData(this);
    $.ajax({
        type:'POST',
        url: 'handlers/reg.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
            location.reload();
        },
        error: function(response, status, error){
           var errors = response.responseJSON;

           if (errors.errors) {
               errors.errors.forEach(function(data, index) {
                   var field = Object.getOwnPropertyNames (data);
                   var value = data[field];
                   var div = $("#"+field[0]).closest('div');
                   div.children('.form-control-feedback').text(value).addClass('alert-danger');
               });
           }

        }
    });
});