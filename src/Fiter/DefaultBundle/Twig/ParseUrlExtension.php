<?php

namespace Fiter\DefaultBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraints\DateTime;

class ParseUrlExtension extends \Twig_Extension{
    

    /**
     * Constructor method
     */
    public function __construct(){  }

    public function getFilters(){
        return array(
            'youtube_id' => new Twig_Filter_Method($this, 'YoutubeIdFilter'),
            'youtube_user_id' => new Twig_Filter_Method($this, 'YoutubeUserIdFilter'),
            'youtube_playlist_id' => new Twig_Filter_Method($this, 'YoutubePlaylistIdFilter'),
        );
    }
    
    /**
     * Like distance_of_time_in_words, but where to_time is fixed to timestamp()
     * @param $url
     * @return String
     */
    function YoutubePlaylistIdFilter($url) {
        $query = \parse_url($url, PHP_URL_QUERY);
        \parse_str($query,$res);
        if ($res) return $res['list'];
        else return "null";
    }
    
    /**
     * Like distance_of_time_in_words, but where to_time is fixed to timestamp()
     * @param $url
     * @return String
     */
    function YoutubeUserIdFilter($url) {
        $path= \str_replace("/user/", "", \parse_url($url, PHP_URL_PATH) );
        if ($path) return $path;
        else return "";
    }

    /**
     * Like distance_of_time_in_words, but where to_time is fixed to timestamp()
     * @param $from_time String
     * @return String
     */
    function YoutubeIdFilter($url) {
        
        $query = \parse_url($url, PHP_URL_QUERY);
        \parse_str($query,$res);
        if ($res) return $res['v'];
        else return "null";
    }

    /**
     * Returns the name of the extension.
     * @return string The extension name
     */
    public function getName(){
        return 'parse_url';
    }


}