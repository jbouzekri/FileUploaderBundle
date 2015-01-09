Reference
=========

This page will not go over the configuration details for each dependency. These bundles already have complete documentation :
* [KnpGaufretteBundle](https://github.com/KnpLabs/KnpGaufretteBundle)
* [OneupUploaderBundle](https://github.com/1up-lab/OneupUploaderBundle/blob/88ae15b1a4e51f0df78394697e7f01bb36e6789d/Resources/doc/index.md)
* [LiipImagineBundle](https://github.com/liip/LiipImagineBundle)

Options Detail
--------------

``` yml
jb_fileuploader:
    resolvers:
        resolver_name:
            resolver_type:
                ... # resolver configuration for the type
    upload_resolver:
    croped_resolver:
    crop_route: jb_image_crop_endpoint
    croped_fs:
    endpoints:
        oneup_endpoint_name:
            upload_resolver:
            croped_resolver:
            croped_fs:
            upload_validators:
                validator_type_1:
                    # validator configuration for the selected type
                # add other validators
            crop_validators:
                validator_type_1:
                    # validator configuration for the selected type
                # add other validators
```

endpoints
---------

`endpoints` key allows to configures each oneup endpoint.

The `oneup_endpoint_name` must match the name of an endpoint in the oneup bundle configuration.

If no configuration has been provided for an endpoint, you must define the global resolver and fs whose will be used as fallback.

resolvers
---------

`resolvers` key is a factory. You can define your own resolvers by specifying a name, a type, and a configuration according to the type.

``` yml
jb_file_uploader:
    resolvers:
        upload:
            assets:
                directory: uploads
```

This example configures a resolver named `upload` of the type `assets`. The type assets demands that you configure a directory key. Here we set `uploads`.
This resolver will be used to generates assets urls from a directory uploads placed in the web folder.

For more information about the different types of resolver, [read the resolver documentation](resolvers.md)

upload_resolver
---------------

`upload_resolver` key configures the resolver to be used when displaying the preview image or the not yet croped image after upload.

It can be configured per endpoint :

``` yml
jb_fileuploader:
    endpoints:
        oneup_endpoint_name:
            upload_resolver: my_upload_resolver
```

Or you can set a global one :

``` yml
jb_fileuploader:
    upload_resolver: my_upload_resolver
```

Note that if an endpoint does not have an upload_resolver, it will try to load the global one.

croped_resolver
---------------

`croped_resolver` key configures the resolver to be used for displaying croped image. It allows to store the croped image in a different folder
or storage from the original.

It can be configured per endpoint :

``` yml
jb_fileuploader:
    endpoints:
        oneup_endpoint_name:
            croped_resolver: my_croped_resolver
```

Or you can set a global one :

``` yml
jb_fileuploader:
    croped_resolver: my_croped_resolver
```

Note that if an endpoint does not have a croped_resolver, it will try to load the global one.

crop_route
----------

`croped_resolver` key configures the route used to crop images

``` yml
jb_fileuploader:
    crop_route: jb_image_crop_endpoint
```

croped_fs
---------

`croped_fs` key configures the gaufrette filesystem used to store the croped image. It is presently used by the croped route when croping an original image.

It can be configured per endpoint :

``` yml
jb_fileuploader:
    endpoints:
        oneup_endpoint_name:
            croped_fs: gaufrette_croped_fs
```

Or you can set a global one :

``` yml
jb_fileuploader:
    croped_fs: gaufrette_croped_fs
```

Note that if an endpoint does not have a croped_fs, it will try to load the global one.

upload_validators
-----------------

`upload_validators` key configures validation when uploading a file. It can be configured per endpoint.

For more information about the different types of validators, [read the validator documentation](validation.md)

*Note : some validation like the file mime type or size must be done with oneup bundle configuration*

crop_validators
---------------

`crop_validators` key configures validation when uploading the croped configuration just before croping the file server side. It can be configured per endpoint.

For more information about the different types of validators, [read the validator documentation](validation.md)
