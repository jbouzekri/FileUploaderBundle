(function ( $ ) {
    "use strict";

    $.fn.jbFileUpload = function( options ) {

        return this.each(function() {

            // Find parent div to allow select of all important children element
            var $parentTag = $('#' +  $(this).data('row-id')),
                $resultError = $parentTag.find('.jb_result_error'),
                $cropTool = $parentTag.find('.jb_crop_tool'),
                $cropUpload = $parentTag.find('.jb_crop_upload'),
                $cropImg = $parentTag.find('.jb_crop_img'),
                $cropX = $parentTag.find('.jb_crop_x'),
                $cropY = $parentTag.find('.jb_crop_y'),
                $cropWidth = $parentTag.find('.jb_crop_width'),
                $cropHeight = $parentTag.find('.jb_crop_height'),
                $cropFilename = $parentTag.find('.jb_crop_filename'),
                naturalWidth, naturalHeight, currentWidth, currentHeight;

            /**
            * Translate message
            *
            * @param {string} msg
            *
            * @returns {string}
            */
           function translateMessage(msg) {
               if (typeof Translator != "undefined") {
                   return Translator.trans(msg);
               }

               return msg;
           }

           /**
            * Toggle the upload field and crop tool
            *
            * @returns {undefined}
            */
           function toggleCropingTool() {
               $cropUpload.toggle();
               $cropTool.toggle();
               $cropX.val('');
               $cropY.val('');
               $cropWidth.val('');
               $cropHeight.val('');
           }

           /**
            * Load the crop tool
            *
            * @param {object} result
            *
            * @returns {undefined}
            */
           function loadCropingTool(result) {
               // Display the crop tool
               toggleCropingTool();

               // Bind coordinate when croping
               function showCoords(c) {
                   $cropX.val(Math.round(c.x * naturalWidth / currentWidth));
                   $cropY.val(Math.round(c.y * naturalHeight / currentHeight));
                   $cropWidth.val(Math.round(c.w * naturalWidth / currentWidth));
                   $cropHeight.val(Math.round(c.h * naturalHeight / currentHeight));
               };

               var cropConfig = {
                   onSelect: showCoords,
                   onChange: showCoords
               };
               $.each($cropImg.data(), function(index, value) {
                   cropConfig[index] = value;
               });
               $cropImg.attr('src', result.filepath).load(function() {
                   naturalHeight = this.naturalHeight;
                   naturalWidth = this.naturalWidth;
                   currentHeight = this.clientHeight;
                   currentWidth = this.clientWidth;
                   $cropImg.Jcrop(cropConfig);
               });
           }

           /**
            * Process an ajax file upload success
            *
            * @type {fileuploadFunction}
            */
            function fileUploadDone(e, data) {
                // Manage error
                $resultError.hide();
                if (typeof data.result.files != "undefined" && typeof data.result.files[0] != "undefined" && typeof data.result.files[0].error != "undefined") {
                    $resultError.show();
                    $resultError.text(translateMessage(data.result.files[0].error));
                    return;
                }

                // If use crop. Load croping tools
                if ($(this).data('use-crop')) {
                    $cropFilename.val(data.result.filename);
                    loadCropingTool(data.result);
                    return;
                }

                $parentTag.find('.jb_result_name').text(data.result.originalname);
                $parentTag.find('.jb_result_filename').val(data.result.filename);

                var $previewTag = $parentTag.find('.jb_result_preview');
                if ($previewTag.prop("tagName") == "IMG") {
                    $previewTag.attr('src', data.result.filepath);
                } else {
                    $previewTag.attr('href', data.result.filepath);
                }
            }

            /**
             * Process the ajax file upload error
             *
             * @param {object} e
             * @param {object} data
             *
             * @returns {undefined}
             */
            function fileUploadError(e, data) {
                if (typeof e.responseJSON[0].message != "undefined") {
                    $resultError.show();
                    $resultError.text(e.responseJSON[0].message);
                }
            }

            // JQuery plugin configuration
            var settings = $.extend({
                // These are the defaults.
                dataType: 'json',
                done: fileUploadDone,
                error: fileUploadError
            }, options );

            // Bind all events
            // Reset field
            $parentTag.find('.jb_crop_reset').click(function(event){
                event.preventDefault();
                $cropImg.data('Jcrop').destroy();
                toggleCropingTool();
            });

            // Confirm field
            $parentTag.find('.jb_crop_confirm').click(function(event){
                event.preventDefault();
                $.post($cropImg.data('url'), $cropTool.find('.jb_crop_field').serialize(), function(data) {
                    console.log(data);
                }, 'json');
            });

            // Load jquery file upload
            $(this).fileupload(settings);
        });
    };
}( jQuery ));