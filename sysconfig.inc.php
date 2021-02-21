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

// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} else if (INDEX_AUTH != 1) {
    die("can not access this file directly");
}

// be sure that magic quote is off
@ini_set('magic_quotes_gpc', false);
@ini_set('magic_quotes_runtime', false);
@ini_set('magic_quotes_sybase', false);
// force disabling magic quotes

/** disable deprecated function
if (get_magic_quotes_gpc()) {
  function stripslashes_deep($value)
  {
    $value = is_array($value)?array_map('stripslashes_deep', $value):stripslashes($value);
    return $value;
  }

  $_POST = array_map('stripslashes_deep', $_POST);
  $_GET = array_map('stripslashes_deep', $_GET);
  $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
  $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}
*/

// turn off all error messages for security reason
@ini_set('display_errors',true);

// set default timezone
// for a list of timezone, please see PHP Manual at "List of Supported Timezones" section
@date_default_timezone_set('Asia/Jakarta');

// nayanes version
define('NAYANES_VERSION', 'Nayanes 5');

// directiry separator shortened
define('DSEP', DIRECTORY_SEPARATOR);

// nayanes base dir
define('NAYANES_BASE_DIR', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

// nayanes library base dir
define('LIB_DIR', NAYANES_BASE_DIR.'lib'.DIRECTORY_SEPARATOR);

// Apply language settings
require LIB_DIR.'lang/localisation.php';

// SEARCH NODE
// Array index/Node Index number MUST BE IN SEQUENTIAL ORDER start from 1
$sysconf['node'][1] = array('url' => 'http://perpustakaan.kemdikbud.go.id/libsenayan', 'desc' => 'Perpustakaan Kementerian Pendidikan dan Kebudayaan');
$sysconf['node'][2] = array('url' => 'http://istinfonet.katalog-induk.net', 'desc' => 'Pusat Perpustakaan Islam Indonesia');
$sysconf['node'][3] = array('url' => 'http://perpustakaan.bapeten.go.id', 'desc' => 'Perpustakaan BAPETEN');
$sysconf['node'][4] = array('url' => 'http://perpustakaan.kpk.go.id/', 'desc' => 'Perpustakaan Komisi Pemberantasan Korupsi (KPK)');
// UCS
$sysconf['node'][5] = array('url' => 'http://ucs.jogjalib.net', 'desc' => 'Union Catalog Yogyakarta Jogjalib.net');
$sysconf['node'][6] = array('url' => 'http://primurlib.net', 'desc' => 'Union Catalog Priyangan Timur Primurlib.net');
$sysconf['node'][7] = array('url' => 'http://makassarlib.net', 'desc' => 'Union Catalog Makassar Makassarlib.net');
$sysconf['node'][8] = array('url' => 'http://jatenglib.net', 'desc' => 'Union Catalog Jawa Tengah');

$sysconf['request_timeout'] = 5000; // in miliseconds

// theme to use
$sysconf['theme'] = 'default';
