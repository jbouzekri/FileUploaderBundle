Javascript Events
=================

There are a few javascript events that get fired that can help you integrate your workflow. These Are:

* jb.FileUpload.success
* jb.FileUpload.error
* jb.FileUpload.remove

The Success event provide an extra object parameter that contains:

    {
        filename: "some-image-name.jpg"
        filepath: "http://the.path.to.the/uploaded/image.ext"
        originalname: "original-image-name.ext"
    }

The remove event provides a similar object, but with empty values.

The error event provides the string error message as its additional parameter.