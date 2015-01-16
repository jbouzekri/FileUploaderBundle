Validate file ownership
=======================

As every query are made via ajax, you could have a person fill the hidden filename input tag with the filename of another user.

To prevent this from happening, a custom validation constraint has been added :

~~~ php
use Jb\Bundle\FileUploaderBundle\Service\Validator\Constraints as JbAssert;

/**
 * @JbAssert\FileOwner
 */
protected $picture;
~~~

With this validator, symfony will check that the submitted file is owned by the user who submitted it.

For it to work, you should have your form submit route behind a firewall.
