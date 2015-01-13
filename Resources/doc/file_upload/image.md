Image file upload
=================

This form type provides file upload optimized for image.

~~~ php
$builder->add('image', 'jb_image_ajax', array(
    'endpoint' => 'my_endpoint_name'
));
~~~

The parent field type is [simple file upload](simple.md). You can use all the options of the parent field.

The specific option are :

* default_image : the image displayed when there is not file uploaded
* img_width : the width of the preview img tag
* img_height : the height of the preview img tag

_Note :_ Upload file validation can be configured in [`config.yml`](../base/validation.md).

