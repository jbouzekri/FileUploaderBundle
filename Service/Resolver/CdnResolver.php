<?php
namespace Jb\Bundle\FileUploaderBundle\Service\Resolver;


/**
 * AssetsResolver
 *
 * @author jobou
 */
class CdnResolver implements ResolverInterface
{

    /**
     * @var string
     */
    protected $url;

    /**
     * Constructor
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($key)
    {
        return $this->url . '/' . $key;
    }
}
