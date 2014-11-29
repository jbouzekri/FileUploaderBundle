(function ( $ ) {
    "use strict";

    function translateMessage(msg) {
        if (typeof Translator != "undefined") {
            return Translator.trans(msg);
        }

        return msg;
    }

    function toggleCropingTool(parentTag) {
        parentTag.find('.jb_crop_upload').toggle();
        parentTag.find('.jb_crop_tool').toggle();
    }

    function loadCropingTool(parentTag, result) {
        toggleCropingTool(parentTag);

        var cropImg = parentTag.find('.jb_crop_img');

        var cropConfig = {};
        $.each(cropImg.data(), function(index, value) {
            cropConfig[index] = value;
        });
        cropImg.attr('src', result.filepath);
        parentTag.find('.jb_crop_img').Jcrop(cropConfig);
    }

    var fileuploadFunction = {
        done: function (e, data) {
            var parentTag = $('#'+$(this).data('row-id'));

            // Manage error
            parentTag.find('.jb_result_error').hide();
            if (typeof data.result.files != "undefined" && typeof data.result.files[0] != "undefined" && typeof data.result.files[0].error != "undefined") {
                parentTag.find('.jb_result_error').show();
                parentTag.find('.jb_result_error').text(translateMessage(data.result.files[0].error));
                return;
            }

            // If use crop. Load croping tools
            if ($(this).data('use-crop')) {
                loadCropingTool(parentTag, data.result);
                return;
            }

            parentTag.find('.jb_result_name').text(data.result.originalname);
            parentTag.find('.jb_result_filename').val(data.result.filename);

            var previewTag = parentTag.find('.jb_result_preview');
            if (previewTag.prop("tagName") == "IMG") {
                previewTag.attr('src', data.result.filepath);
            } else {
                previewTag.attr('href', data.result.filepath);
            }
        },

        error: function (e, data) {
            var parentTag = $('#'+$(this).data('row-id'));

            if (typeof e.responseJSON[0].message != "undefined") {
                parentTag.find('.jb_result_error').show();
                parentTag.find('.jb_result_error').text(e.responseJSON[0].message);
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

        // Bind all events
        var parentTag = $('#' +  this.data('row-id'));

        // Reset field
        parentTag.find('.jb_crop_reset').click(function(event){
            event.preventDefault();
            parentTag.find('.jb_crop_img').data('Jcrop').destroy();
            toggleCropingTool(parentTag);
        });

        // Load jquery file upload
        this.fileupload(settings);

        return this;
    };
}( jQuery ));