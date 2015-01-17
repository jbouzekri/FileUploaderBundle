HTML Markup
===========

The html markup is important as it is used by the jquery plugin to display image preview, crop zone or download link.

File without preview
--------------------

``` html
<div id="test_row" class="file-upload">
    <div class="alert alert-danger jb_result_error" style="display: none;"></div>
    <label for="test" class="required">Test</label>
    <span class="fileinput-button">
        <span><a href="#importFile">Import a file</a></span>
        <input class="jb_fileupload" type="file" name="test" data-url="/app_dev.php/_uploader/gallery/upload" data-row-id="test_row" data-use-crop="false">
    </span>
    <span> | </span>
    <span>
        <a href="#removePicture" class="jb_remove_link" title="Remove">
            Remove
        </a>
    </span>
    <input type="hidden" id="test" name="test[test3]" required="required" class="jb_result_filename" value="">
    <a class="jb_result_preview" data-default="#no-preview" href="#no-preview" style="display: inline;"><span class="jb_result_name"></span></a>
    <img class="jb_loading" src="/bundles/jbfileuploader/img/ajax-loader-small.gif" style="display: none;">
</div>
```

* `.jb_fileupload[data-row-id]` : the attribut data-row-id indicated the parent div rom which we can find using jQuery all children having jb_* class
* `.jb_result_error` : used to display error
* `.fileinput-button` : used in css to hide the input file behind the upload file link
* `.jb_fileupload` : the base class used to activate the jquery plugin. It must be place on the input file.
* `.jb_fileupload[data-url]` : one up endpoint upload url
* `.jb_fileupload[data-use-crop]` : indicate if crop function has been activated
* `.jb_remove_link` : a link to remove an uploaded image (reset the field).
* `.jb_result_filename` : hidden field storing the uploaded filename submitted on post
* `.jb_result_preview` : when using simple file field, display a download link when uploading
* `.jb_result_name` : display the original uploaded file name
* `.jb_loading` : display loading gif while uploading is under way

Image upload with preview
-------------------------

``` html
<div id="test_row" class="file-upload">
    <div class="alert alert-danger jb_result_error" style="display: none;"></div>
    <label for="test" class="required">Test2</label>
    <img class="jb_result_preview" src="/bundles/jbfileuploader/img/default.png" data-default="/bundles/jbfileuploader/img/default.png" width="100" />
    <img class="jb_loading" src="/bundles/jbfileuploader/img/ajax-loader.gif" style="display: none;" />

    <span class="fileinput-button">
        <span><a href="#importFile">Import a file</a></span>
        <input class="jb_fileupload" type="file" name="test_upload_file" data-url="/app_dev.php/_uploader/gallery/upload" data-row-id="test_row" data-use-crop="false">
    </span>
    <span> | </span>
    <span>
        <a href="#removePicture" class="jb_remove_link" title="Remove">
            Remove
        </a>
    </span>
    <input type="hidden" id="test" name="test_upload[test2]" required="required" class="jb_result_filename">
</div>
```

The only difference with the previous field is the `jb_result_preview` tag which is an img instead of a `a`.

* `.jb_result_preview` : display the uploaded image before submitting it
* `.jb_result_preview[data-default]` : the placeholder to fill the preview field while no file has been uploaded.


Image upload with crop
----------------------

``` html
<div id="test_upload_test_row" class="file-upload">
    <div class="alert alert-danger jb_result_error" style="display: none;"></div>
    <label for="test_upload_test" class="required">Test</label>
    <div class="jb_crop_upload">
        <img class="jb_result_preview" src="/bundles/jbfileuploader/img/default.png" data-default="/bundles/jbfileuploader/img/default.png" width="100">
        <img class="jb_loading" src="/bundles/jbfileuploader/img/ajax-loader.gif" style="display: none;">
        <span class="fileinput-button">
            <span><a href="#importFile">Import a file</a></span>
            <input class="jb_fileupload" type="file" name="test_upload_test_file" data-url="/app_dev.php/_uploader/gallery/upload" data-row-id="test_upload_test_row" data-use-crop="true">
        </span>
        <span> | </span>
        <span>
            <a href="#removePicture" class="jb_remove_link" title="Remove">
                Remove
            </a>
        </span>
        <input type="hidden" id="test_upload_test" name="test_upload[test]" required="required" class="jb_result_filename">
    </div>
    <div class="jb_crop_tool" style="display: none;">
        <img class="jb_crop_img" src="" data-aspect-ratio="1" data-set-select="[5,5,20,20]" data-unknown-option="toto" data-url="/app_dev.php/_jbfileuploader/crop/gallery" style="max-width: 350px; max-height: 350px;">
        <button class="jb_crop_confirm">Confirm</button>
        <button type="submit" class="jb_crop_reset">Reset</button>
        <input type="hidden" class="jb_crop_field jb_crop_x" name="jb_fileuploader_crop[x]" value="">
        <input type="hidden" class="jb_crop_field jb_crop_y" name="jb_fileuploader_crop[y]" value="">
        <input type="hidden" class="jb_crop_field jb_crop_width" name="jb_fileuploader_crop[width]" value="">
        <input type="hidden" class="jb_crop_field jb_crop_height" name="jb_fileuploader_crop[height]" value="">
        <input type="hidden" class="jb_crop_field jb_crop_filename" name="jb_fileuploader_crop[filename]" value="">
    </div>
</div>
```
Most of the jb_* classes have been explained above. What add this field is the `jb_crop_tool` zone and wrap the classic image field in a `jb_crop_upload` class.

* `.jb_crop_upload` : wrap image upload with preview. Is hidden when crop is in session.
* `.jb_crop_tool` : wrap the crop zone. Is displayed when crop is in session.
* `.jb_crop_img` : jcrop tag
* `.jb_crop_img[data-*]` : jcrop configuration
* `.jb_crop_confirm` : submit the crop zone to create a croped image
* `.jb_crop_reset` : reset crop zone. Hide the crop zone and display the upload zone.
* `.jb_crop_x` : x position of the crop zone
* `.jb_crop_y` : y position of the crop zone
* `.jb_crop_width` : width of the crop zone
* `.jb_crop_height` : height of the crop zone
* `.jb_crop_filename` : filename to crop

_Note : I am open to pointer to make a plugin less dependant on html markup_