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
    ?>
    <div class="no-result-info alert alert-error"><ul class="no-result-list"></ul></div>
    <?php
    // show result
    echo '<div class="accordion" id="search-result">'."\n";
    if ($_GET['node'] == 'ALL') {
      // MULTIPLE FEDERATED NODE SEARCH
      $s = 1;
      $js_ajaxes = '';
      foreach ($sysconf['node'] as $idx => $node_data) {
        $keywords = urlencode($keywords);
        $nodeHTMLID = 'node'.$idx;
        if (isset($sysconf['node'][$idx+1])) {
          $nextNodeHTMLID = 'node'.($idx+1);
        }
?>
      <div class="accordion-group">
        <div class="accordion-heading" id="<?php echo $nodeHTMLID; ?>-info">
          <h3 class="node-name"><?php echo $node_data['desc']; ?>
          <span class="pull-right"><a class="accordion-toggle btn btn-small btn-warning" data-toggle="collapse" data-parent="#search-result" href="#collapse<?php echo $idx; ?>"><i class="icon-list"></i> <?php echo __('Show search result') ?></a></span>
          </h3>
          <img class="loader" src="./templates/result-loader.gif" />
        </div>
        <div id="collapse<?php echo $idx; ?>" class="accordion-body collapse<?php echo ($s < 2)?' in':''; ?>">
          <div class="accordion-inner" id="<?php echo $nodeHTMLID; ?>">
          </div>
        </div>
      </div>
      <?php
      ob_start();
      if ($s < 2) {
      ?>

        var to<?php echo $nodeHTMLID; ?> = null;
        jQuery.ajax('index.php?p=search-node&nodeid=<?php echo $idx; ?>&keywords=<?php echo $keywords; ?>',
          {type: 'GET',
            beforeSend: function(xhr) {
              to<?php echo $nodeHTMLID; ?> = setTimeout( function() {
                $('.no-result-list').append('<li>REQUEST TIMEOUT from <strong><?php echo $node_data['desc']; ?></strong></li>')
                $('#<?php echo $nodeHTMLID; ?>').parents('.accordion-group').find('.loader').css('display', 'block').show();
                // $('#<?php echo $nodeHTMLID; ?>-info .loader').remove();
                // $('#<?php echo $nodeHTMLID; ?>-info').append('<div class="alert alert-error">REQUEST TIMEOUT</div>');
                xhr.abort();
                <?php if (isset($nextNodeHTMLID)) : ?>
                $('#<?php echo $nextNodeHTMLID; ?>').trigger('<?php echo $nextNodeHTMLID; ?>');
                <?php else : ?>
                if ($('.no-result-info .no-result-list li').length > 0) { $('.no-result-info').slideDown(); }
                <?php endif; ?>
                $('#<?php echo $nodeHTMLID; ?>').parents('.accordion-group').remove();
                },
                <?php echo $sysconf['request_timeout']; ?>);
              }
          }).done(
          function (ajaxData) {
            clearTimeout(to<?php echo $nodeHTMLID; ?>);
            $('#<?php echo $nodeHTMLID; ?>').html(ajaxData);
            <?php if (isset($nextNodeHTMLID)) : ?>
            $('#<?php echo $nextNodeHTMLID; ?>').trigger('<?php echo $nextNodeHTMLID; ?>');
            <?php else : ?>
            if ($('.no-result-info .no-result-list li').length > 0) { $('.no-result-info').slideDown(); }
            <?php endif; ?>
          });

      <?php } else { ?>
        var to<?php echo $nodeHTMLID; ?> = null;
        jQuery('#<?php echo $nodeHTMLID; ?>').bind('<?php echo $nodeHTMLID; ?>', function() {
          jQuery.ajax('index.php?p=search-node&nodeid=<?php echo $idx; ?>&keywords=<?php echo $keywords; ?>',
          {type: 'GET',
            beforeSend: function(xhr) {
              $('#<?php echo $nodeHTMLID; ?>').parents('.accordion-group').find('.loader').css('display', 'block').show();
              to<?php echo $nodeHTMLID; ?> = setTimeout( function() {
                $('.no-result-list').append('<li>REQUEST TIMEOUT from <strong><?php echo $node_data['desc']; ?></strong></li>')
                // $('#<?php echo $nodeHTMLID; ?>-info .loader').remove();
                // $('#<?php echo $nodeHTMLID; ?>-info').append('<div class="alert alert-error">REQUEST TIMEOUT</div>');
                xhr.abort();
                <?php if (isset($nextNodeHTMLID)) : ?>
                $('#<?php echo $nextNodeHTMLID; ?>').trigger('<?php echo $nextNodeHTMLID; ?>');
                <?php else : ?>
                if ($('.no-result-info .no-result-list li').length > 0) { $('.no-result-info').slideDown(); }
                <?php endif; ?>
                $('#<?php echo $nodeHTMLID; ?>').parents('.accordion-group').remove();
                },
                <?php echo $sysconf['request_timeout']; ?>);
              }
            }).done(
            function (ajaxData) {
              clearTimeout(to<?php echo $nodeHTMLID; ?>);
              $('#<?php echo $nodeHTMLID; ?>').html(ajaxData);
              <?php if (isset($nextNodeHTMLID)) : ?>
              $('#<?php echo $nextNodeHTMLID; ?>').trigger('<?php echo $nextNodeHTMLID; ?>');
              <?php else : ?>
              if ($('.no-result-info .no-result-list li').length > 0) { $('.no-result-info').slideDown(); }
              <?php endif; ?>
            });
        });
      <?php }
      $js_ajaxes .= ob_get_clean();
      ?>
<?php
      unset($nextNodeHTMLID);
      $s++;
      }
?>
     <script type="text/javascript">
     jQuery(document).ready( function() {
     <?php echo $js_ajaxes; ?>
     });
     </script>
<?php
    } else {
      // SINGLE NODE SEARCH
      $nodeid = (integer)$_GET['node'];
      $nodeHTMLID = 'node'.$nodeid;
?>
    <div class="accordion-group">
      <div class="accordion-heading" id="<?php echo $nodeHTMLID; ?>-info">
        <span class="result-head"><?php echo __('Search result for: ').'<strong>'.$sysconf['node'][$nodeid]['desc'].'</strong>'; ?></span>
        <img class="loader" src="templates/result-loader.gif" />
      </div>
      <div id="collapse<?php echo $nodeid; ?>" class="accordion-body collapse in">
        <div class="accordion-inner" id="<?php echo $nodeHTMLID; ?>">
        </div>
      </div>
    </div>
    <script type="text/javascript">
      jQuery( function() {
        var to<?php echo $nodeHTMLID; ?> = null;
        jQuery.ajax('index.php?p=search-node&nodeid=<?php echo $nodeid; ?>&keywords=<?php echo $keywords; ?>',
        {type: 'GET',
            beforeSend: function(xhr) {
              $('#<?php echo $nodeHTMLID; ?>').parents('.accordion-group').find('.loader').css('display', 'block').show();
              to<?php echo $nodeHTMLID; ?> = setTimeout( function() {
                $('.no-result-list').append('<li>REQUEST TIMEOUT from <strong><?php echo $sysconf['node'][$nodeid]['desc']; ?></strong></li>')
                // $('#<?php echo $nodeHTMLID; ?>-info .loader').remove();
                // $('#<?php echo $nodeHTMLID; ?>-info').append('<div class="alert alert-error">REQUEST TIMEOUT</div>');
                xhr.abort();
                <?php if (isset($nextNodeHTMLID)) : ?>
                $('#<?php echo $nextNodeHTMLID; ?>').trigger('<?php echo $nextNodeHTMLID; ?>');
                <?php else : ?>
                if ($('.no-result-info .no-result-list li').length > 0) { $('.no-result-info').slideDown(); }
                <?php endif; ?>
                $('#<?php echo $nodeHTMLID; ?>').parents('.accordion-group').remove();
                },
                <?php echo $sysconf['request_timeout']; ?>);
              }
          }).done(
          function (ajaxData) {
            clearTimeout(to<?php echo $nodeHTMLID; ?>);
            $('#<?php echo $nodeHTMLID; ?>').html(ajaxData);
            if ($('.no-result-info .no-result-list li').length > 0) { $('.no-result-info').slideDown(); }
          });
      })
    </script>
<?php
    }
  }
  echo '</div>'."\n";
}
