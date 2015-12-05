/**
 * Created by jsj on 15/12/5.
 */


$(document).ready(function(){
    $(".clear-form").click(function(){
        var form = $(this).parents('form');
        form.find('input[type=text]').val('');
        form.find('select').select2('val',null);
    });
});