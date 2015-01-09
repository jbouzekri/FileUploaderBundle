Resolvers
=========

* [Asset resolver](#assets-resolver)

Assets resolver
---------------

This type of assets is used to display an image or a link to a file when they are stored in the public folder (`web`) or its sub directories.

The only configuration needed is the directory key.

``` yml
jb_file_uploader:
    resolvers:
        croped:
            assets:
                directory: uploads/croped
```

This assets resolver named `croped` will generate urls `/uploads/croped/<filename>`
