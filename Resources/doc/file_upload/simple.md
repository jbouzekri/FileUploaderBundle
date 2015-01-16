Simple file upload
==================

This is the simplest upload field type. It shows an upload link and can display the uploaded filename with a download link when the upload was successful.

~~~ php
$builder->add('file', 'jb_file_ajax', array(
    'endpoint' => 'my_endpoint_name'
));
~~~

The available options are :

* endpoint (_mandatory_) : a oneup fileupload mapping name
* download_link (_boolean_) : show the download link when the upload was successful
* remove_link (_boolean_) : show a remove link allowing to empty the field

