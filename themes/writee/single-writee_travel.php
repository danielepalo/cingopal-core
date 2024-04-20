<?php 
/******************************************/
## Writee theme single-travel.php
## Custom Post Type Name writee_travel.
/******************************************/
global $post;

$sidebar_layout = esc_attr(get_theme_mod('wrt_sidebar_position', '2cr'));

get_header();?>

<style>
  html, body, #map_canvas {
    height: 500px!important;
    width: 100%!important;
  }
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcri93TDDhzQvsu8AonAaj0jbBSsuYq9w"></script>
<script>
	<?php 
	  	$maps_markers = get_post_meta(get_the_ID(), '_wrttrvl_map_pin_address', true);
	  	$marker_address_info = "['".$maps_markers."','The largest mall in Chandigarh Elante hosts premium national and international brands.','url']";
	?>
	var locations = [<?php echo $marker_address_info; ?>];

	var geocoder;
	var map;
	var bounds = new google.maps.LatLngBounds();

	function initialize() {
	  map = new google.maps.Map(
	  document.getElementById("map_canvas"), {
	    center: new google.maps.LatLng(37.4419, -122.1419),
	    zoom: 1,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	  geocoder = new google.maps.Geocoder();
	  for (i = 0; i < locations.length; i++) {
	    geocodeAddress(locations, i);
	  }
	}
	google.maps.event.addDomListener(window, "load", initialize);

	function geocodeAddress(locations, i) {
	  var title = locations[i][0];
	  var address = locations[i][1];
	  var description = locations[i][2]
	  var url = locations[i][3];
	  geocoder.geocode({
	    'address': locations[i][0]
	  },
	  function (results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
	      var marker = new google.maps.Marker({
	      //icon: 'http://maps.google.com/mapfiles/ms/icons/blue.png',
	      map: map,
	      position: results[0].geometry.location,
	      title: title,
	      animation: google.maps.Animation.DROP,
	      address: address,
	      description: description,
	      url: url
	    })
	    infoWindow(marker, map, title, address, description, url);
	    bounds.extend(marker.getPosition());
	    map.fitBounds(bounds);
	    } else {
	      alert("geocode of " + address + " failed:" + status);
	    }
	  });
	}

	function infoWindow(marker, map, title, address, description, url) {
	  google.maps.event.addListener(marker, 'click', function () {
	  var html = "<div><h3>" + title + "</h3><p>" + address + "</p><p>" + description + "<br></div><a href='" + url + "'>View location</a></p></div>";
	    iw = new google.maps.InfoWindow({
	    content: html,
	    maxWidth: 350
	  });
	    iw.open(map, marker);
	  });
	}

	function createMarker(results) {
	  var marker = new google.maps.Marker({
	    //icon: 'http://maps.google.com/mapfiles/ms/icons/blue.png',
	    map: map,
	    position: results[0].geometry.location,
	    title: title,
	    animation: google.maps.Animation.DROP,
	    address: address,
	    description: description,
	    url: url
	  })
	  bounds.extend(marker.getPosition());
	  map.fitBounds(bounds);
	  infoWindow(marker, map, title, address, description, url);
	  
	  return marker;
	}
</script> 
<center><?php writee_featured_image(get_the_ID(), 'WRT-post-image');?></center>
	<div itemscope itemtype="http://schema.org/TouristAttraction">
		<?php 
		$prefix = '_wrttrvl_';

		if(have_posts()):
			while(have_posts()): the_post(); 
			$id = get_the_ID();?>
			<center>
				<?php the_title( '<span itemprop="name"><h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2></span>' );?>
			</center>
			</span>
			<!-- Place Map -->
			<span itemprop="hasMap"><div id="map_canvas" style="height:400px;!important"></div></span>
			<!-- End Place Map -->
			<hr>
			<strong>Date of Travel:</strong>
    			<?php echo date('F j, Y',get_post_meta($id , $prefix.'date_of_travel', true));?>	
    		<span style="float:right;"><strong>Total Expense</strong>
    		<?php  echo get_post_meta($id, $prefix.'total_expense', true);?>
    		</span>
    		<hr>
    		<span itemprop="description"><?php the_content();?></span>
    		<hr>
    		<h3>Popular Food</h3>
    		<?php  
    			$trvl_popular_foods = get_post_meta($id, $prefix.'popular_food', true);
    			foreach($trvl_popular_foods as $trvl_popular_food){ ?>
    				<img itemprop="photo" src="<?php echo $trvl_popular_food;?>" height="200px" width="200px"/>
    		<?php }?>
    		<hr>
    		<?php $travel_things = get_post_meta($id, $prefix.'essential_thing', true);?>
          	<div>
          		<h6><span>Essential Things To Carry</span></h6>
          		<div>
          			<?php foreach($travel_things as $travel_thing) { ?>
          				<a><?php echo "<i class='fa fa-check' aria-hidden='true'></i> ".$travel_thing; ?></a>
          			<?php } ?>
				</div>
			</div>
			<hr>
          	<table>
          		<thead>
          			<th>Location Type</th>
          			<th>Country</th>
          			<th>City</th>
          		</thead>
          		<tbody>
          			<td><?php echo get_post_meta($id, $prefix .'location_type', true);?></td>
          			<td><?php echo get_post_meta($id, $prefix .'country', true);?></td>
          			<td><?php echo get_post_meta($id, $prefix .'city', true);?></td>
          		</tbody>
          	</table>
          	<?php $location_review_options = get_post_meta($id, $prefix .'wrt_trvl_location_review', true);?>
          	<table>
				<tbody>
					<tr>
						<th>Review Label</th>
						<th >Review Score</th>
					</tr>
					<?php 
					$i = '';
					foreach($location_review_options as $location_review_option) {?>
					<tr>
						<td><?php echo $location_review_option['_wrttrvl_location_label']?></td>
						<td><?php echo $location_review_option['_wrttrvl_location_value']; ?></td>
					</tr>
					<?php $i++;}?>
				</tbody>
			</table>
		<?php	endwhile;
			else:
					get_template_part('inc/theme/views/content-none'); 
			endif; 
		?>
		<?php 
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template('', true );
			endif;
		?>
	</div>
	<?php if($sidebar_layout == '2cl' || $sidebar_layout == '2cr'): ?>
	<div class="site-sidebar" id="sidebar" role="complementary">
		<?php get_sidebar(); ?>
	</div>
	<?php endif; ?>
<?php get_footer();?>