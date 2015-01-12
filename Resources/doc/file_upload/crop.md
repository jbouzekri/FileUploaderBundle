Image file upload with crop
===========================

This form type provides file upload optimized for image with a crop function based on [jquery jcrop plugin](http://github.com/tapmodo/Jcrop).

~~~ php
$builder->add('cropedImage', 'jb_crop_image_ajax', array(
    'endpoint' => 'my_endpoint_name',
));
~~~

The parent field type is [image file upload](image.md). You can use all the options of the parent field.

The specific option are :

* default_image : the image displayed when there is not file uploaded
* max_width : the max width in pixels of the crop img tag (not the croping zone)
* max_height : the max height in pixels of the crop img tag (not the croping zone)
* reset_button : (_boolean_) display a reset button which reset the crop tag
* reset_button_label : the label of the reset button if reset_button is true
* confirm_button_label : the label of the confirm button which submit the croping information
* crop_options : options passed to the jCrop instance in javascript thanks to `data-*` attribute

Example :

~~~ php
$builder->add('example', 'jb_crop_image_ajax', array(
    'endpoint' => 'my_endpoint_name',
    'img_width' => 100,
    'crop_options' => array(
        'aspect-ratio' => 1,
        'set-select' => "[5,5,20,20]"
    )
));
~~~

This configuration force jCrop to propose a crop zone with a ration of 1 and a starting crop zone starting at [5,5] with a width of 20 and height of 20.

Available jcrop options :

* aspectRatio : decimal Aspect ratio of w/h (e.g. 1 for square)
* minSize : array [ w, h ] Minimum width/height, use 0 for unbounded dimension
* maxSize : array [ w, h ] Maximum width/height, use 0 for unbounded dimension
* setSelect : array [ x, y, x2, y2 ] Set an initial selection area
* bgColor : color value Set color of background container
* bgOpacity : decimal 0 - 1 Opacity of outer image when cropping

More information on [jcrop documentation page](http://deepliquid.com/content/Jcrop_Manual.html)