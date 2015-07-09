<?php if(!defined('GX_LIB')) die("Direct Access Not Allowed!");
/**
* GeniXCMS - Content Management System
* 
* PHP Based Content Management System and Framework
*
* @package GeniXCMS
* @since 0.0.1 build date 20141006
* @version 0.0.6
* @link https://github.com/semplon/GeniXCMS
* @link http://genixcms.org
* @author Puguh Wijayanto (www.metalgenix.com)
* @copyright 2014-2015 Puguh Wijayanto
* @license http://www.opensource.org/licenses/mit-license.php MIT
*
*/

$post="";
$data['max'] = Options::get('post_perpage');
if(isset($_GET['paging'])){
    $paging = Typo::int($_GET['paging']);
    if($paging > 0) {
        $offset = ($paging-1)*$data['max'];
    }else{
        $offset = 0;
    }
    $pagingtitle = " - Page {$paging}";
}else{
    $offset = 0;
    $paging = 1;
    $pagingtitle = "";
}
//echo $paging;
$data['sitetitle'] = Site::$slogan.$pagingtitle;
$data['posts'] = Db::result(
                        sprintf("SELECT * FROM `posts` 
                            WHERE `type` = 'post' 
                            AND `status` = '1'
                            ORDER BY `date` 
                            DESC LIMIT %d, %d",
                            $offset, $data['max']
                            )
                        );
$data['num'] = Db::$num_rows;

if(Options::get('multilang_enable') === 'on') {
    
    if (isset($_GET['lang'])) {
        foreach ($data['posts'] as $p) {
            if (Posts::existParam('multilang', $p->id)
                && Options::get('multilang_default') !== $_GET['lang']) {
                # code...
                $multilang = json_decode(Posts::getParam('multilang', $p->id),true);
                foreach ($multilang as $key => $value) {
                    // print_r($value);
                    $keys = array_keys($value);
                    // print_r($keys);
                    if ($keys[0] == $_GET['lang']) {
                        $lang = $multilang[$key][$_GET['lang']];
                        $posts = get_object_vars($p);
                        $posts = array_replace($posts, $lang);
                    }else{
                        $posts = $p;
                    }
                }
                
                
            }else{
                $posts = $p;
            }
            $posts_arr = array();
            $posts_arr = json_decode(json_encode($posts), FALSE);
            // $posts[] = $posts;
            $post_arr[] = $posts_arr;
            $data['posts'] = $post_arr;
        }
    }else{
        $data['posts'] = $data['posts'];
    }
    

}else{
    $data['posts'] = $data['posts'];
}

$url = (SMART_URL)? Site::$url: Site::$url.'/index.php?';
$paging = array(
                'paging' => $paging,
                'table' => 'posts',
                'where' => '`type` = \'post\'',
                'max' => $data['max'],
                'url' => $url,
                'type' => Options::get('pagination')
            );
$data['paging'] = Paging::create($paging, SMART_URL);
Theme::theme('header',$data);
Theme::theme('index', $data);
Theme::footer();

/* End of file default.control.php */
/* Location: ./inc/lib/Control/Frontend/default.control.php */