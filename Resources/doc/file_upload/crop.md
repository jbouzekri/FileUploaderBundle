Image file upload with crop
===========================

Installation
------------

If you want to use the crop field type, you must add the croping route to your `app/config/routing.yml` :

```yml
jb_fileupload_crop:
    resource: "@JbFileUploaderBundle/Resources/config/routing.yml"
```

Getting started
---------------

The getting started configuration provided in the [getting started](../base/getting_started.md) documentation must be extended to manage the crop field.

This is a simple extension working for all basic cases :

``` yml
knp_gaufrette:
    stream_wrapper: ~
    adapters:
        image:
            local:
                directory: %kernel.root_dir%/../web/uploads
                create: true
        croped:
            local:
                directory: %kernel.root_dir%/../web/uploads/croped
                create: true
    filesystems:
        image:
            adapter: image
            alias: image_filesystem
        croped:
            adapter: croped
            alias: croped_filesystem

oneup_uploader:
    mappings:
        gallery:
            frontend: blueimp
            storage:
                type: gaufrette
                filesystem: gaufrette.image_filesystem
                stream_wrapper: gaufrette://image/

jb_file_uploader:
    resolvers:
        upload:
            assets:
                directory: uploads
        croped:
            assets:
                directory: uploads/croped
    croped_fs: croped
    croped_resolver: croped
    endpoints:
        gallery:
            upload_resolver: upload
            upload_validators: {}
            crop_validators: {}

liip_imagine:
    data_loader: stream.image_filesystem
    loaders:
        stream.image_filesystem:
            stream:
                wrapper: gaufrette://image/
        stream.croped_filesystem:
            stream:
                wrapper: gaufrette://croped/
    filter_sets:
        original: ~
        thumb_from_original:
            quality: 75
            filters:
                thumbnail: { size: [120, 90], mode: outbound }
        thumb_from_croped:
            data_loader: stream.croped_filesystem
            quality: 75
            filters:
                thumbnail: { size: [120, 90], mode: outbound }
```

This configuration provides 2 knp gaufrette filesystems :

* `gaufrette.image_filesystem` with the stream `gaufrette://image/` which stores file in the `web/uploads` folder
* `gaufrette.croped_filesystem` with the stream `gaufrette://croped/` which stores file in the `web/uploads/croped` folder

The ajax file uploader for oneup bundle stores original uploaded file in the `gaufrette.image_filesystem` filesystem.

The jb fileuploader configuration provides :

* a `upload` resolver with generates relative url for files located in the `web/uploads` folder
* a `croped` resolver with generates relative url for files located in the `web/uploads/croped` folder
* `croped_fs` configures the gaufrette filesystem to be used to fetch and stores croped image file
* `croped_resolver` configures the resolver to be used to generate croped image url and render them
* and an endpoint matching the one in oneup bundle

The liip imagine bundle configures :

* 2 data loaders : one for original images stored in `gaufrette.image_filesystem` and another one for the croped ones stored in `gaufrette.croped_filesystem`
* Per default, it fetches original images with the `stream.image_filesystem`
* 2 filter sets example : one resizing from the original image `thumb_from_original` and the other resizing from the croped image `thumb_from_croped`
* a global data loader indicating

Reference
---------

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