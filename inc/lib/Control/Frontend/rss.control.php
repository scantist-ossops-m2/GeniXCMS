<?php

defined('GX_LIB') or die('Direct Access Not Allowed!');
/**
 * GeniXCMS - Content Management System
 *
 * PHP Based Content Management System and Framework
 *
 * @since 0.0.1 build date 20150131
 *
 * @version 1.1.12
 *
 * @link https://github.com/semplon/GeniXCMS
 * 
 *
 * @author Puguh Wijayanto <metalgenix@gmail.com>
 * @copyright 2014-2021 Puguh Wijayanto
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
    System::gZip();

    Rss::create();
    
    System::Zipped();
/* End of file rss.control.php */
/* Location: ./inc/lib/Control/Frontend/rss.control.php */
