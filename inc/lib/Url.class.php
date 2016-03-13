<?php if(!defined('GX_LIB')) die("Direct Access Not Allowed!");
/**
* GeniXCMS - Content Management System
*
* PHP Based Content Management System and Framework
*
* @package GeniXCMS
* @since 0.0.1 build date 20140930
* @version 0.0.7
* @link https://github.com/semplon/GeniXCMS
* @link http://genixcms.org
* @author Puguh Wijayanto (www.metalgenix.com)
* @copyright 2014-2015 Puguh Wijayanto
* @license http://www.opensource.org/licenses/mit-license.php MIT
*
*/

/**
* Url Class
*
* This class will create all the URL format automatically for Posts, Categories,
* pages, sitemap, rss.
*
*
* @author Puguh Wijayanto (www.metalgenix.com)
* @since 0.0.1
*/
class Url
{
    public function __construct() {
    }

    /**
    * Post URL Function.
    * This will create the posts url automatically based on the SMART_URL
    * will formatted as friendly url if SMART_URL is set to true.
    *
    * @author Puguh Wijayanto (www.metalgenix.com)
    * @since 0.0.1
    */
    public static function post($vars) {
        switch (SMART_URL) {
            case true:
                $inFold = (Options::v('permalink_use_index_php') == "on")? "/index.php/":"/";
                if (Options::v('multilang_enable') === 'on') {
                    $lang = Language::isActive();
                    $lang = !empty($lang)? $lang . '/': '';
                    $url = Site::$url.$inFold. $lang .self::slug($vars)."/{$vars}";
                }else{
                    $url = Site::$url.$inFold.self::slug($vars)."/{$vars}";
                }

                break;

            default:
                if (Options::v('multilang_enable') === 'on') {
                    $lang = Language::isActive();
                    $lang = !empty($lang)? '&lang=' . $lang: '';
                    $url = Site::$url."/?post={$vars}{$lang}";
                }else{
                    $url = Site::$url."/?post={$vars}";
                }
                break;

        }

        return $url;
    }

    /**
    * Page URL Function.
    * This will create the pages url automatically based on the SMART_URL
    * will formatted as friendly url if SMART_URL is set to true.
    *
    * @author Puguh Wijayanto (www.metalgenix.com)
    * @since 0.0.1
    */
    public static function page($vars) {
        switch (SMART_URL) {
            case true:
                $inFold = (Options::v('permalink_use_index_php') == "on")? "/index.php/":"/";
                if (Options::v('multilang_enable') === 'on') {
                    $lang = Language::isActive();
                    $lang = !empty($lang)? $lang . '/': '';
                    $url = Site::$url.$inFold. $lang .self::slug($vars).GX_URL_PREFIX;
                }else{
                    $url = Site::$url.$inFold.self::slug($vars).GX_URL_PREFIX;
                }
                break;

            default:
                if (Options::v('multilang_enable') === 'on') {
                    $lang = Language::isActive();
                    $lang = !empty($lang)? '&lang=' . $lang: '';
                    $url = Site::$url."/?page={$vars}{$lang}";
                }else{
                    $url = Site::$url."/?page={$vars}";
                }

                break;

        }

        return $url;
    }


    /**
    * Categories URL Function.
    * This will create the categories url automatically based on the SMART_URL
    * will formatted as friendly url if SMART_URL is set to true.
    *
    * @author Puguh Wijayanto (www.metalgenix.com)
    * @since 0.0.1
    */
    public static function cat($vars) {
        switch (SMART_URL) {
            case true:
                # code...
                $inFold = (Options::v('permalink_use_index_php') == "on")? "/index.php":"";
                $url = Site::$url.$inFold."/category/".$vars."/".Typo::slugify(Categories::name($vars));
                break;

            default:
                # code...
                $url = Site::$url."/?cat={$vars}";
                break;

        }

        return $url;
    }

    /**
    * Custom URL Function.
    * This will create the custom url. It will result as is.
    *
    * @author Puguh Wijayanto (www.metalgenix.com)
    * @since 0.0.1
    */
    public static function custom($vars) {
        $url = $vars;
        return $url;
    }

    /**
    * Sitemap URL Function.
    * This will create the sitemap url automatically based on the SMART_URL
    * will formatted as friendly url if SMART_URL is set to true.
    *
    * @author Puguh Wijayanto (www.metalgenix.com)
    * @since 0.0.1
    */
    public static function sitemap() {
        switch (SMART_URL) {
            case true:
                # code...
                $inFold = (Options::v('permalink_use_index_php') == "on")? "/index.php":"";
                $url = Site::$url.$inFold."/sitemap".GX_URL_PREFIX;
                break;

            default:
                # code...
                $url = Site::$url."/index.php?page=sitemap";
                break;

        }

        return $url;
    }

    /**
    * RSS URL Function.
    * This will create the rss url automatically based on the SMART_URL
    * will formatted as friendly url if SMART_URL is set to true.
    *
    * @author Puguh Wijayanto (www.metalgenix.com)
    * @since 0.0.1
    */
    public static function rss() {
        switch (SMART_URL) {
            case true:
                # code...
                $inFold = (Options::v('permalink_use_index_php') == "on")? "/index.php":"";
                $url = Site::$url.$inFold."/rss".GX_URL_PREFIX;
                break;

            default:
                # code...
                $url = Site::$url."/index.php?rss";
                break;

        }

        return $url;
    }

    /**
    * URL Slug Function.
    * This will load the url slug from the database according to the posts id.
    *
    * @author Puguh Wijayanto (www.metalgenix.com)
    * @since 0.0.1
    */
    public static function slug($vars) {
        $s = Db::result("SELECT `slug` FROM `posts` WHERE `id` = '{$vars}' LIMIT 1");
        $s = $s[0]->slug;
        return $s;
    }


    /**
    * FLag URL Function.
    * This will create the flag url automatically based on the SMART_URL
    * will formatted as friendly url if SMART_URL is set to true.
    *
    * @author Puguh Wijayanto (www.metalgenix.com)
    * @since 0.0.7
    */
    public static function flag($vars) {
        switch (SMART_URL) {
            case true:
                $lang = '?lang=' . $vars;
                if (isset($_GET['lang'])) {

                    $uri = explode('?', $_SERVER['REQUEST_URI']);
                    $uri = $uri[0];
                }else{
                    $uri = $_SERVER['REQUEST_URI'];
                }
                $url = $uri . $lang;

                break;

            default:
                // print_r($_GET);
                if (!empty($_GET)) {

                    $val = '';
                    foreach ($_GET as $key => $value) {
                        if ($key == 'lang') {
                            $val .= '&lang='.$vars;
                        }else{
                            $val .= $key . '=' . $value;
                        }
                    }
                }else{
                    $val = "lang=".$vars;
                }
                $lang = !isset($_GET['lang'])? '&lang=' . $vars: $val;
                $url = Site::$url . '/?' . $lang;
                break;

        }

        return $url;
    }

}

/* End of file Url.class.php */
/* Location: ./inc/lib/Url.class.php */
