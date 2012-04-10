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

if ( !isset($_GET['keywords']) && !isset($_GET['nodeid']) ) {
  exit('No search query defined');
} else {
  $keywords = trim(strip_tags($_GET['keywords']));
  $nodeid = trim(strip_tags($_GET['nodeid']));
  if (!($keywords && $nodeid)) {
    echo '<div class="alert alert-error">Empty query or Node ID</div>';
  } else if (!isset($sysconf['node'][$nodeid])) {
    echo '<div class="alert alert-error">Node ID not found</div>';
  } else {
    sleep(2);
    // include MODS XML library
    require LIB_DIR.'modsxmlsenayan.inc.php';

    // keywords
    $keywords = urlencode(trim($_GET['keywords']));

    // fetch XML data
    $slims_url = $sysconf['node'][$nodeid]['url'];
    $data = modsXMLsenayan($slims_url."/index.php?resultXML=true&search=Search&keywords=".$keywords, 'uri');
    if ($data === MODS_XML_PARSE_ERROR) {
      // echo '<div class="alert alert-error">Error on fetching SLiMS records from '.$slims_url.'</div>';
    }

    if ($data['records']) {
      echo '<table class="table table-striped nayanes-result">'."\n";
      echo '<thead>'."\n";
      echo '<tr>'."\n";
      echo '<td>'.__('No.').'</td>';
      echo '<td>'.__('Title').'</td>';
      echo '<td>'.__('Format').'</td>';
      echo '<td>'.__('ISBN/ISSN').'</td>';
      echo '<td>'.__('Detail').'</td>';
      echo '</tr>'."\n";
      echo '</thead>';
      echo '<tbody>';
      $row = 1;
      foreach($data['records'] as $record) {
        echo '<tr>';
        echo '<td class="field-no">'.$row.'</td>';
        echo '<td class="field-title"><strong>'.$record['title'].'</strong>';
        echo '<div class="field-author">';
        // concat authors name
        $buffer_authors = '';
        foreach ($record['authors'] as $author) { $buffer_authors .= $author['name'].' - '; }
        echo substr_replace($buffer_authors, '', -3);
        echo '</div>';
        echo '</td>';
        echo '<td class="field-format">'.$record['gmd'].'</td>';
        echo '<td class="field-isbn">'.$record['isbn_issn'].'</td>';
        echo '<td><a class="btn btn-info show-detail" href="'.$slims_url.'/index.php?p=show_detail&id='.$record['id'].'" target="blank">'.__('Detail').'</a></td>';
        echo '</tr>';
        $row++;
      }
      if ($data['result_num'] > $row) {
        echo '<tr>';
        echo '<td class="field-no">&nbsp;</td>';
        echo '<td colspan="4"><a class="btn btn-success btn-small field-more" href="'.$slims_url.'/index.php?search=Search&keywords='.$keywords.'&page=2" target="blank">'.__('View more result from this provider').'</a></td>';
        echo '</tr>';
      }
      echo '</tbody>'."\n";
      echo '</table>'."\n";
      ?>
      <script type="text/javascript">
      jQuery(function() {
        $('#node<?php echo $nodeid; ?>-info .loader').remove();
        $('#node<?php echo $nodeid; ?>-info').append('<?php echo '<div class="alert alert-success result-info">'.sprintf(__('Found %d record(s)'), $data['result_num']).'</div>' ?>');
      });
      </script>
      <?php
    } else {
      ?>
      <script type="text/javascript">
      jQuery(function() {
        $('#node<?php echo $nodeid; ?>-info .loader').remove();
        $('#node<?php echo $nodeid; ?>-info').append('<?php echo '<div class="alert alert-error">'.sprintf(__('Sorry, no result found from <strong>%s</strong> OR maybe XML result and detail disabled.'), $sysconf['node'][$nodeid]['desc']).'</div>' ?>');
      });
      </script>
      <?php
    }

  }
}
exit();