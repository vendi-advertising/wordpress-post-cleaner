<?php

namespace Vendi\WordPressPostCleaner;

class WP_Post_Extended
{
    private $_post;

    private $_urls = [];

    private $_primary_url;

    public function set_primary_url_by_post()
    {
        $this->_primary_url = \get_permalink($this->_post);
    }

    public function get_primary_url() : string
    {
        if(null===$this->_primary_url){
            $this->set_primary_url_by_post();
        }

        return $this->_primary_url;
    }

    public function add_url(string $url)
    {
        $this->_urls[] = $url;
    }

    public function __construct(\WP_Post $post)
    {
        $this->_post = $post;
        $this->set_primary_url_by_post();
    }

    // public function __isset( $key )
    // {
    //     return $his->_post->__isset($key);
    // }

    // public function __get( $key )
    // {
    //     return $his->_post->__get($key);
    // }
}
