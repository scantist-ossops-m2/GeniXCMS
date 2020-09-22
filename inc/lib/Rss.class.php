<?php

defined('GX_LIB') or die('Direct Access Not Allowed!');
/**
 * GeniXCMS - Content Management System.
 *
 * PHP Based Content Management System and Framework
 *
 * @since 0.0.1 build date 20141005
 *
 * @version 1.1.9
 *
 * @link https://github.com/semplon/GeniXCMS
 * 
 *
 * @author Puguh Wijayanto <psw@metalgenix.com>
 * @copyright 2014-2020 Puguh Wijayanto
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class Rss
{
    public function __construct()
    {
    }

    public static function create($count = '20', $url = 'post', $type = 'post', $class = 'Url')
    {
        $var = array(
                'num' => $count,
                'type' => $type,
            );
        $posts = Posts::recent($var);
        header('Content-Type: text/xml');
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '
<!-- RSS Generated by GeniXCMS on '.Date::format(date('Y-m-d H:i:s'), 'D, j M Y H:i:s O').' -->
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>'.Site::$name.'</title>
        <link>'.Site::$url.'</link>
        <description>'.Site::$desc.'</description>
        <lastBuildDate>'.Date::format(date('Y-m-d H:i:s'), 'D, j M Y H:i:s O').'</lastBuildDate>
        <atom:link href="'.Site::$url.'/rss/" rel="self" type="application/rss+xml" />
            ';
        if (!isset($posts['error'])) {
            foreach ($posts as $p) {
                $xml .= '
        <item>
            <title>'.strip_tags(Typo::Xclean($p->title)).'</title>
            <description>'.preg_replace('/&nbsp;/i', '', $p->content).'</description>
            <pubDate>'.Date::format($p->date, 'D, j M Y H:i:s O').'</pubDate>
            <link>'.$class::$url($p->id).'</link>
            <guid>'.$class::$url($p->id).'</guid>
        </item>
                ';
            }
        }

        $xml .= '

    </channel>
</rss>
                ';
        echo $xml;
    }
}
