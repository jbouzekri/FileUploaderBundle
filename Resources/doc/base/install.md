Installation
============

Update composer
---------------

Add the bundle to your `composer.json` :

``` json
{
    "require": {
        "jbouzekri/file-uploader-bundle": "~2.0"
    }
}
```

And run the composer update command :

```
php composer.phar update
```

_Note : this bundle use some symfony 2.6 services. If you have an earlier version, you should require
`"jbouzekri/file-uploader-bundle": "~1.0"` as at this time it was not dependant on these services._

Enable bundles
--------------

In the file `AppKernel.php`, enable all bundles necessary for this one :

``` php
public function registerBundles()
{
    $bundles = array(
        ...

        new Oneup\UploaderBundle\OneupUploaderBundle(),
        new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
        new Liip\ImagineBundle\LiipImagineBundle(),
        new Jb\Bundle\FileUploaderBundle\JbFileUploaderBundle(),
    );

    ...
}
```

Configure Oneup
---------------

Add the base configuration for oneup bundle in `app/config.yml` :

``` yml
oneup_uploader:
    mappings:
        gallery:
            frontend: blueimp
```

Enable the oneup upload route at the start of the `app/routing.yml` :

``` yml
oneup_uploader:
    resource: .
    type: uploader
```

For more information about the oneup configuration, jump to  [the bundle documentation](https://github.com/1up-lab/OneupUploaderBundle/blob/master/Resources/doc/index.md)

Configure Liip
--------------

Add the base configuration for liip bundle in `app/config.yml` with a special filter named original which will be used to serve the original image :

``` yml
liip_imagine:
    filter_sets:
        original: ~
```

Enable the liip resize route at the start of the `app/routing.yml` :

``` yml
_liip_imagine:
    resource: "@LiipImagineBundle/Resources/config/routing.xml"
```

Load bundle form type theme
---------------------------

This bundle provides form fields. You must load their HTML layout. In `app/config.yml`, reference the bundle form template :

```
twig:
    form:
        resources:
            - 'JbFileUploaderBundle:Form:fields.html.twig'
```

File metadata storage
---------------------

The bundle stores some metadata in a table to keep trace of original file name or original uploader.

Run the doctrine schema update command to create the table.

```
php app/console doctrine:schema:update --force
```

Install assets
--------------

The bundle and its dependencies provide some assets. Do not forget to run the assets install command :

```
php app/console assets:install web --symlink
```

Load assets
-----------

In your template or in the symfony base one `app/Resources/views/base.html.twig`, load all necessary assets :

``` twig
{% block stylesheets %}
<link href="{{ asset('bundles/jbfileuploader/lib/jquery-file-upload/css/jquery.fileupload.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('bundles/jbfileuploader/css/jbfileupload.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('bundles/jbfileuploader/lib/jcrop/css/jquery.Jcrop.min.css') }}" type="text/css" rel="stylesheet" />
{% endblock %}

{% block javascripts %}
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="{{ asset('bundles/jbfileuploader/lib/jquery-file-upload/js/vendor/jquery.ui.widget.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/jbfileuploader/lib/jquery-file-upload/js/jquery.iframe-transport.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/jbfileuploader/lib/jquery-file-upload/js/jquery.fileupload.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/jbfileuploader/js/jbfileupload.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bundles/jbfileuploader/lib/jcrop/js/jquery.Jcrop.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('.jb_fileupload').jbFileUpload();
        });
    </script>
{% endblock %}
```

End
---

You have completed the basic installation. The bundle cannot be use yet because the base configuration does not provide enough information.

Jump to the [Getting Started](getting_started.md) page to view a usable configuration reference and its explanation.
