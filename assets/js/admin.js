jQuery(document).ready(function($){
    $('#srsb-test-ai').on('click', function(e){
        e.preventDefault();

        $('#srsb-test-ai-output').html('Testing…');

        $.post(
            ajaxurl,
            {
                action: 'srsb_test_ai'
            },
            function(response){
                if(response.success){
                    $('#srsb-test-ai-output').html('<strong>Success:</strong> ' + response.data);
                } else {
                    $('#srsb-test-ai-output').html('<strong>Error:</strong> ' + response.data);
                }
            }
        );
    });
});
