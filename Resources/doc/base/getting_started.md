Getting started
===============

This section will present a base configuration which can be used in most project.

In this configuration, you will have a folder :
* `web/uploads` which will host original files
* `web/media` which will host liip resized images

Configuration
-------------

``` yml
knp_gaufrette:
    stream_wrapper: ~
    adapters:
        image:
            local:
                directory: %kernel.root_dir%/../web/uploads
                create: true
    filesystems:
        image:
            adapter: image
            alias: image_filesystem

oneup_uploader:
    mappings:
        gallery:
            frontend: blueimp
            storage:
                type: gaufrette
                filesystem: gaufrette.image_filesystem
                stream_wrapper: gaufrette://image/

liip_imagine:
    loaders:
        stream.image_filesystem:
            stream:
                wrapper: gaufrette://image/
    filter_sets:
        original: ~
        thumb_from_original:
            data_loader: stream.image_filesystem
            quality: 75
            filters:
                thumbnail: { size: [120, 90], mode: outbound }

jb_file_uploader:
    resolvers:
        upload:
            assets:
                directory: uploads
    endpoints:
        gallery:
            upload_resolver: upload
            upload_validators: {}
            crop_validators: {}
```

How to use
----------

In your entity, add a field to store the image name :

``` php
/**
 * @ORM\Column(type="string", length=100, nullable=true)
 */
protected $image;
```

In a form type, use [image field type](../file_upload/image.md) on your new image attribute :

``` php
$builder->add('image', 'jb_image_ajax', array(
    'img_width' => 400,
    'endpoint' => 'gallery'
));
```

This field provides an ajax image file upload. It uses the configured `gallery` oneup endpoint.

The next paragraph will explain each bundle configuration.

__Note: All folders must be created (`web/uploads`, `web/media`) and must be writable by apache.__

knp_gaufrette explanation
-------------------------

``` yml
knp_gaufrette:
    stream_wrapper: ~
    adapters:
        image:
            local:
                directory: %kernel.root_dir%/../web/uploads
                create: true
    filesystems:
        image:
            adapter: image
            alias: image_filesystem
```

This bundle provides a gaufrette filesystem abstraction for a `web/uploads` folder.
This filesystem is name image, has the alias image_filesystem and use the adapter image.

oneup explanation
-----------------

``` yml
oneup_uploader:
    mappings:
        gallery:
            frontend: blueimp
            storage:
                type: gaufrette
                filesystem: gaufrette.image_filesystem
                stream_wrapper: gaufrette://image/
```

This yml configures an endpoint for oneup file upload used when uploading the file.

This endpoint uses jquery file uploader (blueimp) which is the only one supported by JbFileUploader
and uses the filesystem gaufrette aliases gaufrette_filesystem accessed by its stream wrapper.

liip explanation
----------------

``` yml
liip_imagine:
    loaders:
        stream.image_filesystem:
            stream:
                wrapper: gaufrette://image/
    filter_sets:
        original: ~
        thumb_from_original:
            data_loader: stream.image_filesystem
            quality: 75
            filters:
                thumbnail: { size: [120, 90], mode: outbound }
```

This yml configures a file loader using the gaufrette image filesystem (the one storing the uploaded files).

Then 2 filters :
* original : a technical filters used by the bundle to serve orginal files
* thumb_from_original : a filter resizing image to a thumbnail of 120x90

jb explanation
--------------

``` yml
jb_file_uploader:
    resolvers:
        upload:
            assets:
                directory: uploads
    endpoints:
        gallery:
            upload_resolver: upload
            upload_validators: {}
            crop_validators: {}
```

This yml configure a resolver upload which will help to build url relative to the uploads folder to preview the uploaded file.

For each oneup endpoint, we set the configured resolver to use. Here, the gallery endpoint used the image gaufrette filesystem which will put
 all files in the web/uploads folder. So to generate an url, we need a resolver of type asset which will use the uploads directory : `/uploads/<filename>`).

More complicated settings
-------------------------

This setting provides base configuration but you can go very more deeply with file type validation, ratio, image width or height validation, croping, croping result validation
or saving in other storage :
* [validation](validation.md)
* [crop field type and configuration](../file_upload/crop.md)
* [storage in amazon s3](../advanced/amazons3.md)