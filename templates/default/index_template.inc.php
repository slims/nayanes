<!DOCTYPE html>
<!--
  Arie Nugraha 2012. dicarve@gmail.com
  dicarve.blogspot.com
  this template taken and modified from Bootstrap starter template
  http://twitter.github.com/bootstrap/examples/starter-template.html -->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- main styles -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="lib/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="templates/default/js/supersized.core.css" rel="stylesheet">
    <link href="templates/default/style.css" rel="stylesheet">

    <script src="lib/jquery.js"></script>
    <!-- For IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="lib/html5.js"></script>
    <![endif]-->

    <!-- favorite and touch icons -->
    <link rel="shortcut icon" href="lib/favicon.ico">
  </head>

  <body>
    <div id="masking"></div>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.php">Nayanes: SLiMS Search Proxy</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="http://slims.web.id" target="blank">SLiMS</a></li>
              <li><a href="index.php?p=about">About Nayanes</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

    <!-- simple search -->
    <form class="well form-search">
    <input type="hidden" name="p" value="search" />
    <label><?php echo __('Keywords'); ?></label>
    <input type="text" name="keywords" class="input-medium search-query" value="<?php echo isset($_GET['keywords'])?trim($_GET['keywords']):'' ?>">
    <select name="node">
      <option value="ALL"><?php echo __('All nodes'); ?></option>
      <?php foreach($sysconf['node'] as $idx => $node) {
        echo '<option value="'.$idx.'">'.$node['desc'].'</option>';
       } ?>
    </select>
    <button type="submit" class="btn btn-primary"><?php echo __('Search now'); ?></button>
    <a data-toggle="modal" data-target="#advSearchModal" class="btn btn-info" ><?php echo __('Advanced search'); ?></a>
    </form>

    <!-- advanced search -->
    <div id="advSearchModal" class="modal fade hide">
    <form id="adv-search-form" action="index.php" method="get">
    <div class="modal-header">
      <a class="close" data-dismiss="modal">x</a>
      <h3>Nayanes: <?php echo __('Advanced search'); ?></h3>
    </div>
    <div class="modal-body">
    <input type="hidden" name="advsearch" value="1" />
    <input type="hidden" name="p" value="search" />
		<table>
			<tr>
				<td class="value">
				<?php echo __('Title'); ?>
				</td>
				<td class="value">
				  <input type="text" name="title" />
				</td>
				<td class="value">
				<?php echo __('Author(s)'); ?>
				</td>
				<td class="value">
				  <input type="text" name="author" />
				</td>
			</tr>
			<tr>
				<td class="value">
				<?php echo __('Subject(s)'); ?>
				</td>
				<td class="value">
				<input type="text" name="subject" />
				</td>
				<td class="value">
				<?php echo __('ISBN/ISSN'); ?>
				</td>
				<td class="value">
					<input type="text" name="isbn" />
				</td>
			</tr>
			<tr>
				<td class="value">
					<?php echo __('Location'); ?>
				</td>
				<td class="value" colspan="3">
					<select name="node" class="full-width">
          <option value="ALL"><?php echo __('All nodes'); ?></option>
          <?php foreach($sysconf['node'] as $idx => $node) {
            echo '<option value="'.$idx.'">'.$node['desc'].'</option>';
          } ?>
					</select>
				</td>
			</tr>
		</table>
    </div>
    <div class="modal-footer">
      <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="btn btn-primary btn-large" />
      <a class="btn btn-danger btn-large close" data-dismiss="modal">Close</a>
    </div>
    </form>
    </div>

    <div id="main-content">
    <?php echo $main_content; ?>
    </div>

    </div> <!-- /container -->

    <script src="templates/default/js/supersized.3.1.3.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    jQuery(function($){
      $.supersized(
      {
          transition		: 6,
          keyboard_nav 	: 0,
          start_slide		: 0,
          vertical_center : 1,
          horizontal_center : 1,
          min_width	: 1000,
          min_height : 700,
          fit_portrait  : 1,
          fit_landscape	: 0,
          image_protect	: 1,
          slides		: [
            { image : 'templates/default/images/1.jpg' },
            { image : 'templates/default/images/2.jpg' }
          ]
      });
    });
    </script>
  </body>
</html>
