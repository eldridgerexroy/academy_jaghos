(function ($) {
    "use strict";



    console.log("testing")
    $('body').on('change', '.js-template-type', function (e) {
        Swal.fire("test")
        // const value = $(this).val();
        // const $text = $('.js-text-fields');
        // const $image = $('.js-image-fields');
        // const $prompt = $('.js-prompt-field');
        // const $textPromptHint = $('.js-text-prompt-hint');
        // const $imagePromptHint = $('.js-image-prompt-hint');

        // $text.addClass('d-none');
        // $image.addClass('d-none');
        // $prompt.addClass('d-none');
        // $textPromptHint.addClass('d-none');
        // $imagePromptHint.addClass('d-none');

        // if (value === "text") {
        //     $text.removeClass('d-none');
        //     $textPromptHint.removeClass('d-none');
        // } else if (value === "image") {
        //     $image.removeClass('d-none');
        //     $imagePromptHint.removeClass('d-none');
        // }

        // if (value) {
        //     $prompt.removeClass('d-none')
        // }
    });
})(jQuery);
