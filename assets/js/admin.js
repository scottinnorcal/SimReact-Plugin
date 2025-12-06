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

    $('#srsb-ai-generate-button').on('click', function(e){
        e.preventDefault();

        const prompt  = $('#srsb_ai_prompt').val();
        const section = $('#srsb_ai_section').val();

        if (!prompt || !section) {
            $('#srsb-ai-generation-output').html('<strong>Error:</strong> Please choose a section and enter a prompt.');
            return;
        }

        $('#srsb-ai-generation-output').html('Generating...');

        $.post(
            ajaxurl,
            {
                action: 'srsb_generate_ai_copy',
                section: section,
                prompt: prompt
            },
            function(response){
                if(response.success){
                    $('#srsb-ai-generation-output').html('<pre>' + response.data + '</pre>');
                } else {
                    $('#srsb-ai-generation-output').html('<strong>Error:</strong> ' + response.data);
                }
            }
        );
    });
});
