Amazon S3 storage
=================

By using the abstraction storage Gaufrette, we can easily change the way we store files. Moreover, LiipImagineBundle comes with a lot of connector one of
them being for aws3.

Install aws3 php sdk
--------------------

In your `composer.json` :

~~~ json
{
    "require": {
        "aws/aws-sdk-php": "~2.7.14"
    }
}
~~~

Of course, run the `composer update` command.

Full configuration example
--------------------------

Init necessary services in `services.yml` file (or other extension) :

~~~ yml
services:
    acme.aws_s3.client:
        class: Aws\S3\S3Client
        factory_class: Aws\S3\S3Client
        factory_method: 'factory'
        arguments:
            -
                key: <your aws3 key>
                secret: <your aws3 secret>
                region: <your aws3 buckets region>

    liip_imagine.cache.resolver.aws3:
          class: Jb\Bundle\FileUploaderBundle\Service\Imagine\AwsS3Resolver
          arguments:
              - "@acme.aws_s3.client"
              - "<your bucket name>"
          calls:
              - [ setCachePrefix, ['media_cache'] ]
          tags:
              - { name: 'liip_imagine.cache.resolver', resolver: 'cache.aws3' }
~~~

We have configured 2 services :

* `acme.aws_s3.client` : a aws3 client using the aws3 php library
* `liip_imagine.cache.resolver.aws3` : An aws3 image cache resolver to store liip resized pictures in aws3

You must set your own aws3 key, secret and region. In the liip cache resolver, you must set your bucket name and an eventual folder for storing all cache file
via the calls directive `setCachePrefix`.

Then, we configure our bundles,  starting with the gaufrette one :

~~~ yml
knp_gaufrette:
    stream_wrapper: ~
    adapters:
        profile_photos:
            aws_s3:
                service_id: 'acme.aws_s3.client'
                bucket_name: '<your bucket name>'
                options:
                    directory: 'upload_test'
                    acl: 'public-read'
        croped_photos:
            aws_s3:
                service_id: 'acme.aws_s3.client'
                bucket_name: '<your bucket name>'
                options:
                    directory: 'croped_test'
                    acl: 'public-read'
    filesystems:
        s3_original:
            adapter: profile_photos
            alias: s3_original_filesystem
        s3_croped:
            adapter: croped_photos
            alias: s3_croped_filesystem
~~~

We have 2 adapters used in 2 differents file systems. The first filesystem `s3_original` using the adapter `profile_photos` will store all original uploaded
images in the directory `upload_test`. The second filesystem `s3_croped` using the adapter `croped_photos` will store all croped images in the directory `croped_test`.

Then, we have the configuration for the oneup uploader bundle :

~~~ yml
oneup_uploader:
    mappings:
        s3_original:
            frontend: blueimp
            storage:
                type: gaufrette
                filesystem: gaufrette.s3_original_filesystem
                stream_wrapper: gaufrette://s3_original/
~~~

We configure an unique endpoint for uploading the original image (the croped one has its own route provided by `jb_file_uploader`. See [reference](../base/reference.md) for more information).
It used the gaufrette filesystem `s3_original`. So original file will be store in the `profile_photos` folder.

Then, we have the configuration for the jbfileupload bundle :

~~~ yml
jb_file_uploader:
    resolvers:
        amazon:
            aws3:
                service_id: acme.aws_s3.client
                bucket: "<you bucket name>"
                directory: upload_test
        croped_amazon:
            aws3:
                service_id: acme.aws_s3.client
                bucket: "<you bucket name>"
                directory: croped_test
    endpoints:
        s3_original:
            upload_resolver: amazon
            croped_resolver: croped_amazon
            croped_fs: s3_croped
            upload_validators: {}
            crop_validators: {}
~~~

2 resolvers will be created to be able to generate url to the 2 differents folder in our bucket :

* `amazon` : the one for original image using the upload_test folder
* `croped_amazon` : the one for croped image

In oneup bundle, we use the mapping `s3_original` so we configure it in `jb_file_uploader`. There we configure :

* The resolver used for original image `amazon`
* The resolver used for croped image `croped_amazon`
* The gaufrette filesystem to use to store image after crop `s3_croped`
* Optionnaly, you could add [validation](../base/validation.md)

Last, we configure the liip bundle :

~~~ yml
liip_imagine:
    cache: cache.aws3
    data_loader: stream.image_filesystem
    loaders:
        stream.image_filesystem:
            stream:
                wrapper: gaufrette://s3_original/
        stream.croped_filesystem:
            stream:
                wrapper: gaufrette://s3_croped/
    filter_sets:
        original: ~
        my_thumb:
            quality: 75
            filters:
                thumbnail: { size: [120, 90], mode: outbound }
~~~

We have configured :

* the cache storage to store cached resized image in aws3 `cache.aws3`. This is the service created at the start of this page.
* 2 loaders to load original and croped images
* A global data_loader using the loader for original image

The global data loader means that liip will always use the original image when resizing. However you can put this configuration in each filter sets. So you
can control for each one if it should start resizing from the croped one or the original one.

