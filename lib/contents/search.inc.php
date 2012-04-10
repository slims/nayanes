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
  }

  if (!$keywords) {
    echo '<div class="alert alert-error">'.__('No query supplied. Please insert one or more keywords to search').'</div>';
  } else {
    // show result
    echo '<div class="accordion" id="search-result">'."\n";
    if ($_GET['node'] == 'ALL') {
      $s = 1;
      foreach ($sysconf['node'] as $idx => $node_data) {
?>
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#search-result" href="#collapseOne">
            <?php echo __('Search result for: ').'<strong>'.$node_data['desc'].'</strong>'; ?>
          </a>
        </div>
        <div id="collapseOne" class="accordion-body in" style="height: auto; ">
          <div class="accordion-inner">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
          </div>
        </div>
      </div>
<?php
      $s++;
      }
    } else {
?>
    <div class="accordion-group">
      <div class="accordion-heading">
        <span class="result-head"><?php echo __('Search result for: ').'<strong>'.$sysconf['node'][$_GET['node']]['desc'].'</strong>'; ?></span>
      </div>
      <div id="collapseOne" class="accordion-body in" style="height: auto; ">
        <div class="accordion-inner">
          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
        </div>
      </div>
    </div>
<?php
    }
  }
  echo '</div>'."\n";
}