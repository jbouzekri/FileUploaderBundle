(function ( $ ) {
    "use strict";

    var fileuploadFunction = {
        done: function (e, data) {
            var parentTag = $(this).parents('.file-upload');

            parentTag.find('.result_error').hide();

            if (typeof data.result.files != "undefined" && typeof data.result.files[0] != "undefined" && typeof data.result.files[0].error != "undefined") {
                parentTag.find('.result_error').show();
                parentTag.find('.result_error').text(Translator.trans(data.result.files[0].error));
            }

            parentTag.find('.result_name').text(data.result.originalname);
            parentTag.find('.result_filename').val(data.result.filename);

            var previewTag = parentTag.find('.result_preview');
            if (previewTag.prop("tagName") == "IMG") {
                previewTag.attr('src', data.result.filepath);
            } else {
                previewTag.attr('href', data.result.filepath);
            }
        },

        error: function (e, data) {
            var parentTag = $('#'+$(this).attr('id')).parents('.file-upload');

            if (typeof e.responseJSON[0].message != "undefined") {
                parentTag.find('.result_error').show();
                parentTag.find('.result_error').text(e.responseJSON[0].message);
            }
        }
    };

    $.fn.jbFileUpload = function( options ) {
        var settings = $.extend({
            // These are the defaults.
            dataType: 'json',
            done: fileuploadFunction.done,
            error: fileuploadFunction.error
        }, options );

        this.fileupload(settings);

        return this;
    };
}( jQuery ));