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

resolvers
---------


upload_resolver
---------------


croped_resolver
---------------


crop_route
----------


croped_fs
---------


upload_validators
-----------------


crop_validators
---------------

