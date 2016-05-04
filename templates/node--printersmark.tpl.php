<?php
        // debug
        if (isset($_GET['debug'])) {
                print "<pre>";
                print_r($content);
                print '</pre>';
        }
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h3<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h3>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

<?php
	/* JD - don't get rid of meta stuff b/c it is used on the home page slideshow */
?>

  <?php if ($display_submitted || !empty($content['links']['terms'])): ?>
    <div class="meta">
      <?php if ($display_submitted && isset($submitted) && $submitted): ?>
        <span class="submitted"><?php print $submitted; ?></span>
      <?php endif; ?>

      <?php if (!empty($content['links']['terms'])): ?>
        <div class="terms terms-inline">
          <?php print render($content['links']['terms']); ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <?php if (!$teaser): ?>
    <div id="node-top" class="node-top region nested">
      <?php print render($node_top); ?>
    </div>
  <?php endif; ?>
  
  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);

	if ($teaser) {
		// get summary out there
		print render($content);
		print render($content['links']); // need $readmore
	}

	else {	
?>


<?php
	// remove these vars for now so that we can display them later if needed
	hide($content['field_missing_window']);
	hide($content['field_picture_of_mark']);
	hide($content['field_printername']);
	hide($content['field_printer_birthdeath']);
	hide($content['field_date']);
	hide($content['field_geolocation']);
	hide($content['field_originalloc']);
	hide($content['field_currentloc']);
	hide($content['field_bio']);


	// handy variables:
	$picture_of_mark = '/islandora/object/';
	$markpid = 'vassar:root';
	if (isset($field_picture_of_mark)) {
		$picture_of_mark .= $field_picture_of_mark[0]['safe_value'] . "/datastream/TN/view";
		$markpid = $field_picture_of_mark[0]['safe_value'];
	}
	$geolocation = '/printersmarks/browse-location/';
	$country = '';
	if (isset($field_geolocation)) {
		$geolocation .= $field_geolocation[0]['safe_value'];
		$country = ucfirst($field_geolocation[0]['safe_value']);
	}

	$body = $node->body['und'][0]['safe_value'];

	// Need to transform current library location

	$currentLocLookups = array(
"c51rr" => "Class of '51 Reading Room",
"ewnw" => "End window -- North wing",
"ewsw" => "End window -- South wing",
"nw1w" => "North wing -- First window",
"nw2w" => "North wing -- Second window",
"nw3w" => "North wing -- Third window",
"nw4w" => "North wing -- Fourth window",
"nw5w" => "North wing -- Fifth window",
"nw6w" => "North wing -- Sixth window",
"ww1w" => "West wing -- First window",
"ww2w" => "West wing -- Second window",
"ww3w" => "West wing -- Third window",
"ww4w" => "West wing -- Fourth window",
"ww5w" => "West wing -- Fifth window",
"ww6w" => "West wing -- Sixth window",
"sw1w" => "South wing -- First window",
"sw2w" => "South wing -- Second window",
"sw3w" => "South wing -- Third window",
"sw4w" => "South wing -- Fourth window",
"sw5w" => "South wing -- Fifth window",
"sw6w" => "South wing -- Sixth window",
	);

	$currentloc = "Class of '51 Reading Room";
	if (isset($field_currentloc)) {
		$l = $field_currentloc[0]['safe_value'];
		$currentloc = $currentLocLookups[$l];	
	}
?>
<?php
	/* ******* FEATURED IMAGE ******** */
	$featuredImage = '<div class="featuredMark">' . "\n";
	$featuredImage .= "<h4>Printer's Mark</h4>\n";
        $featuredImage .= '<a href="/islandora/object/' . $markpid. '"><img src="' . $picture_of_mark . '" alt="View of Vassar Library window of ' . $title . '\'s mark" /></a>';
	$featuredImage .= "</div> <!-- .featuredImage --> \n";
	?>

	<?php print $featuredImage; ?>

<h4>About this printer</h4>
<?php print render($content['field_printername']); ?>
<?php print render($content['field_printer_birthdeath']); ?>
<?php // print render($content['field_geolocation']); ?>
<?php // the names did not come through with uppercase in values / labels ?>
<div class="field field-name-field-geolocation field-type-text field-label-above"><div class="field-label">Geographic location of printer:&nbsp;</div><div class="field-items"><div class="field-item even"><a href="<?php echo $geolocation; ?>"><?php echo $country; ?></a></div></div></div>
<h4>Biography</h4>
<?php print render($content); ?>
<h4>About the device</h4>
<?php print render($content['field_date']); ?>
<?php //print render($content['field_currentloc']); ?>
<?php // these locations didn't come through properly ?>

<div class="field field-name-field-currentloc field-type-text field-label-above"><div class="field-label">Current library location:&nbsp;</div><div class="field-items"><div class="field-item even"><?php echo $currentloc; ?></div></div></div>


<?php print render($content['field_bio']); ?>
<?php	
	
	} // end IF-ELSE teaser vs page
?>

  </div> <!-- .content -->


  <?php if (!$teaser): ?>
    <div id="node-bottom" class="node-bottom region nested">
      <?php print render($node_bottom); ?>
    </div>
  <?php endif; ?>
  
</div>

