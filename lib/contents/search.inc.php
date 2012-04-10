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

if ( !isset($_GET['keywords']) && !isset($_GET['advsearch']) ) {
  echo 'No search query defined';
} else {
  if (isset($_GET['keywords'])) {
    $keywords = trim(strip_tags($_GET['keywords']));
  }
  if (isset($_GET['advsearch'])) {
    $keywords = '';
    if ($title = trim($_GET['title'])) { $keywords .= ' title='.$title; }
    if ($author = trim($_GET['author'])) { $keywords .= ' author='.$author; }
    if ($subject = trim($_GET['subject'])) { $keywords .= ' subject='.$subject; }
    if ($isbn = trim($_GET['isbn'])) { $keywords .= ' isbn='.$isbn; }
    $keywords = trim($keywords);
  }

  if (!$keywords) {
    echo '<div class="alert alert-error">'.__('No query supplied. Please insert one or more keywords to search').'</div>';
  } else {
    // show result
    echo '<div class="accordion" id="search-result">'."\n";
    if ($_GET['node'] == 'ALL') {
      // MULTIPLE FEDERATED NODE SEARCH
      $s = 1;
      foreach ($sysconf['node'] as $idx => $node_data) {
        $keywords = urlencode($keywords);
        $nodeHTMLID = 'node'.$idx;
?>
      <div class="accordion-group">
        <div class="accordion-heading" id="<?php echo $nodeHTMLID; ?>-info">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#search-result" href="#collapse<?php echo $idx; ?>">
            <?php echo __('Search result for: ').'<strong>'.$node_data['desc'].'</strong>'; ?>
          </a>
          <img class="loader" src="templates/result-loader.gif" />
        </div>
        <div id="collapse<?php echo $idx; ?>" class="accordion-body collapse<?php echo ($s < 2)?' in':''; ?>">
          <div class="accordion-inner" id="<?php echo $nodeHTMLID; ?>">
          </div>
        </div>
      </div>
      <script type="text/javascript">
        jQuery( function() {
          jQuery.ajax('index.php?p=search-node&nodeid=<?php echo $idx; ?>&keywords=<?php echo $keywords; ?>',
          {type: 'GET'}).done(
            function (ajaxData) {
              $('#<?php echo $nodeHTMLID; ?>').html(ajaxData);
            });
        })
      </script>
<?php
      $s++;
      }
    } else {
      // SINGLE NODE SEARCH
      $nodeid = (integer)$_GET['node'];
?>
    <div class="accordion-group">
      <div class="accordion-heading">
        <span class="result-head"><?php echo __('Search result for: ').'<strong>'.$sysconf['node'][$nodeid]['desc'].'</strong>'; ?></span>
        <img class="loader" src="templates/result-loader.gif" />
      </div>
      <div id="collapseOne" class="accordion-body collapse in">
        <div class="accordion-inner" id="nodeResult">
        </div>
      </div>
    </div>
    <script type="text/javascript">
      jQuery( function() {
        jQuery.ajax('index.php?p=search-node&nodeid=<?php echo $nodeid; ?>&keywords=<?php echo $keywords; ?>',
        {type: 'GET'}).done(
          function (ajaxData) {
            $('#nodeResult').html(ajaxData);
          });
      })
    </script>
<?php
    }
  }
  echo '</div>'."\n";
}