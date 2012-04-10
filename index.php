<?php
/**
 *
 * Copyright (C) 2012  Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

define('INDEX_AUTH', 1);

require 'sysconfig.inc.php';

// set default vars
$page_title = 'Nayanes: The SLiMS Search Proxy';
$main_content = '';

// start the output buffering for main content
ob_start();
if (isset($_GET['p'])) {
  $path = trim(strip_tags($_GET['p']));
  // some extra checking
  $path = preg_replace('@^(http|https|ftp|sftp|file|smb):@i', '', $path);
  $path = preg_replace('@\/@i','',$path);
  // check if the file exists
  if (file_exists(LIB_DIR.'contents/'.$path.'.inc.php')) {
    include LIB_DIR.'contents/'.$path.'.inc.php';
  } else {
    include LIB_DIR.'contents/default.inc.php';
  }
} else {
  include LIB_DIR.'contents/default.inc.php';
}
// main content grab
$main_content = ob_get_clean();

require 'templates/'.$sysconf['theme'].'/index_template.inc.php';