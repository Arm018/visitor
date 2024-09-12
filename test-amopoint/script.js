$(document).ready(function() {
    $("input[name^='input_']").hide();
    $("input[name^='button_']").hide();


    $("select[name='type_val']").on('change', function() {



        $("input[name^='input_']").hide();
        $("input[name^='button_']").hide();


        $("input[name='input_" + selectedType + "']").show();
        $("input[name='button_" + selectedType + "']").show();
    });


    $("select[name='type_val']").trigger('change');
});
