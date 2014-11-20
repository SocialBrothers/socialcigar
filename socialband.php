<?php

function fetchUrl($url){

 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_TIMEOUT, 20);
 // You may need to add the line below
 // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

 $feedData = curl_exec($ch);
 curl_close($ch); 

 return $feedData;

}


add_action('admin_menu', 'sb_plugin_setup_menu');
 
function sb_plugin_setup_menu(){
        add_menu_page( 'Social Band', 'Social Band', 'manage_options', 'socialband', 'init_sbsocial' );
		add_action( 'admin_init', 'registersbsettingssocial' );
}

function registersbsettingssocial() {
	//register our settings
	register_setting( 'baw-settings-group', 'instagramclient' );
	register_setting( 'baw-settings-group', 'instasecret' );
	register_setting( 'baw-settings-group', 'instatoken' );
		register_setting( 'baw-settings-group', 'fbclient' );
		register_setting( 'baw-settings-group', 'fbsecret' );
	register_setting( 'baw-settings-group', 'exclude1' );
		register_setting( 'baw-settings-group', 'exclude2' );
		register_setting( 'baw-settings-group', 'fbpageid' );
	
}

 
function init_sbsocial(){
        echo "<h1>Social Band instellingen</h1>";
		?>
		<form method="post" action="options.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <?php do_settings_sections( 'baw-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">instagramclient</th>
        <td><input style="width: 330px;" type="text" name="instagramclient" value="<?php echo esc_attr( get_option('instagramclient') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Instagram secret</th>
        <td><input style="width: 330px;"  type="text" name="instasecret" value="<?php echo esc_attr( get_option('instasecret') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Insta-token</th>
        <td><input style="width: 330px;"  type="text" name="instatoken" value="<?php echo esc_attr( get_option('instatoken') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">FB Page ID</th>
        <td><input style="width: 330px;"  type="text" name="fbpageid" value="<?php echo esc_attr( get_option('fbpageid') ); ?>" /></td>
        </tr>
        
         <tr valign="top">
        <th scope="row">FB App ID</th>
        <td><input style="width: 330px;"  type="text" name="fbclient" value="<?php echo esc_attr( get_option('fbclient') ); ?>" /></td>
        </tr>
        
         <tr valign="top">
        <th scope="row">FB Secret</th>
        <td><input style="width: 330px;"  type="text" name="fbsecret" value="<?php echo esc_attr( get_option('fbsecret') ); ?>" /></td>
        </tr>
        
           <tr valign="top">
        <th scope="row">Exclude url 1</th>
        <td><input style="width: 330px;"  type="text" name="exclude1" value="<?php echo esc_attr( get_option('exclude1') ); ?>" /></td>
        </tr>
        
          <tr valign="top">
        <th scope="row">Exclude url 2</th>
        <td><input style="width: 330px;"  type="text" name="exclude2" value="<?php echo esc_attr( get_option('exclude2') ); ?>" /></td>
        </tr>
        
    </table>
    
    <?php submit_button(); ?>

</form>
<?php
}
 
 
 //6876547.d491955.5dd20f9181ec423c89df6f4b6679c66d
 
 // Add Shortcode
function sb_social_func() {
	ob_start();
	$fbfotourlarray  = array();
	$fbfototextarray  = array();
	$instafotourlarray  = array();
	$instafototextarray  = array();
	$instaurlarray  = array();
	
	$profile_id = esc_attr( get_option('fbpageid'));

//App Info, needed for Auth
$app_id = esc_attr( get_option('fbclient') );
$app_secret = esc_attr( get_option('fbsecret') );

//Retrieve auth token
$authToken = fetchUrl("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$app_id}&client_secret={$app_secret}");

$json_object = fetchUrl("https://graph.facebook.com/{$profile_id}/feed?{$authToken}");

$feed = json_decode($json_object);
$data = $feed->data;
$teller = 0;
foreach ($data as $key => $value) {
	
 if	($value->type == 'photo' && $teller < 3){
 	$image_object = fetchUrl("https://graph.facebook.com/{$value->object_id}");
	$image_object = json_decode($image_object);
	$fbfotourlarray[] = $image_object->images[0]->source;
	$fbfototextarray[] = $value->message;
	
//	echo $imageurl	.'<br>';
	 $teller++;
 }

	
}

//	print_r($json_object);
	/*
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => 'https://graph.facebook.com/v2.2/139075012008?fields=feed',
	    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	
	// Close request to clear up some resources
	curl_close($curl);
	print_r($resp);
	*/
	
	
	$URL = 'https://api.instagram.com/v1/tags/linteloo/media/recent?access_token='. esc_attr( get_option('instatoken') ) .'&count=10';
	// Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here
	curl_setopt_array($curl, array(
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_URL => $URL,
	    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
	));
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
	
	
	$response = json_decode($resp);
	$data = $response->data;
	foreach ($data as $key => $value) :
		//echo $value->caption->text;
		if($value->link != esc_attr( get_option('exclude1')) && $value->link != esc_attr( get_option('exclude2'))  ) {
		$instaurlarray []= $value->link;
		$instafototextarray [] = $value->caption->text;
		$instafotourlarray []= $value->images->standard_resolution->url;
		}
	endforeach;
	//print_r($data);
	
	
	?>
	<div id="box">
  

  
</div>
	<div class="sbbandcol1">
        <!-- kolom 1 -->
         <!-- kolom 1-1 -->
         
         	<div class="sbbandcol11">
		     		<div onclick="window.open('<?php echo $instaurlarray[0] ?>');" class="sbcolboven" style="cursor:pointer; background-image: url('<?php echo $instafotourlarray[0]; ?>')">
		       		</div>
	        	<div class="sbcolboven">
					
						 
						<div onclick="window.open('<?php echo $instaurlarray[1] ?>');" class="sbbandcollinks" style="cursor:pointer; background-image: url('<?php echo $instafotourlarray[1]; ?>')">

						</div>
						
						<div onclick="window.open('<?php echo $instaurlarray[2] ?>');" class="sbbandcollinks" style="cursor:pointer; background-image: url('<?php echo $instafotourlarray[2]; ?>')">

						</div>
					
	        	</div>
        	</div>
        	
         <!-- kolom 1-1 -->
         <div class="sbbandcol12">
         		<div class="sbcolonderderde">
         		
         		 <div onclick="window.open('<?php echo $instaurlarray[3] ?>');" class="sbbandcollinks" style="cursor:pointer; background-image: url('<?php echo $instafotourlarray[3]; ?>')">
						</div>
						<div onclick="window.open('<?php echo $instaurlarray[4] ?>');" class="sbbandcollinks" style="cursor:pointer; background-image: url('<?php echo $instafotourlarray[4]; ?>')">
						</div>
         		
         			</div>
       			
       				<div onclick="window.open('<?php echo $instaurlarray[5] ?>');" class="sbcolbovenderde" style="cursor:pointer; background-image: url('<?php echo $instafotourlarray[5]; ?>')">
         		</div>
         	
        	</div>
        
	</div>
	<div class="sbbandcol2">
        <!-- kolom 2 -->
        <div class="sbbandcol11">
        	<div class="sbcolboven">
        			<div class="sbbandcollinks" style="   background-image: url(<?php echo $fbfotourlarray[1]; ?>)">
        				<div class="redO">"<?php echo $fbfototextarray[1] ?>" 	</div>
        			</div>        		
        				<div onclick="window.open('<?php echo $instaurlarray[6] ?>');" class="sbbandcollinks" style="cursor:pointer; background-image: url('<?php echo $instafotourlarray[6]; ?>')">
        				
        			</div>
        	</div>
        	<div class="sbcolboven" style="  background-image: url(<?php echo $fbfotourlarray[0]; ?>)">
        			<div class="redO">"<?php echo $fbfototextarray[0] ?>"  	</div>
        	</div>
     
        </div>
         <div class="sbbandcol12">
         		
         			<div onclick="window.open('<?php echo $instaurlarray[7] ?>');" class="sbcolbovenderde" style="cursor:pointer; background-image: url('<?php echo $instafotourlarray[7]; ?>')">
         		</div>
         		<div class="sbcolonderderde" style="  background-image: url(<?php echo $fbfotourlarray[2]; ?>)">
         				<div class="redO">"<?php echo $fbfototextarray[2] ?>"	</div>
         		</div>
        
        </div>
        
        
	</div>
	
	<?php
	return ob_get_clean();
}
add_shortcode( 'sbsocialband', 'sb_social_func' );


?>
