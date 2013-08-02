<?php 

/**
 * This class handles the Frontend Functions and Display of our Endorse Heads. Also Displays the Endorsements
 * with no Endorse Heads
 *
 * @since     1.0.0
 */
class Endorse_Heads_Frontend {


	/**
	 * Main Endorse Heads Front End Construct
	 *
	 * @since     1.0.0
	 */
	 public function __construct(){
		global $prefix;
		$prefix = 'i4_';
	 }

	 /**
	 * The Endorse Heads Loop.
	 *
	 * @since 	  1.0.0
	 */
	  public function endorse_heads_loop() {

		//Setup the args
		$args = array(
			'post_type' => 'tennis_endorsement',  //query the endorsements post type
			'meta_key' => 'i4_endorser_display',  //query the Endorser Heads
			'meta_value' => 'Endorser Heads'
		);
		$query = new WP_Query( $args );

		// The Loop
		echo '<ul class="thumbnails">';
		
		if ($query->have_posts()) :  //Make sure there are Endorse Heads
		
		while ( $query->have_posts() ) : $query->the_post(); 
			
			global $postID;  //Setup Global Variable for Post ID
			$postID = get_the_ID(); //grab the Post ID
			
			echo '<li class="span2">';
			echo '<div class="endorse-head-wrap">';
		
			//Display The Endorse Head Pic
			$this->endorse_head_pic();
			
			//Display The Endorsers Name
			echo '<h5 class="endorser-name">'.get_the_title() .'</h5>';
		
			//Display The Endorsers Title
			//$this->get_endorser_title();
			
			//Display The Business Name
			$this->get_business_name(false);
			
			//Display The Social Media Links
			$this->get_quote();
			
			echo '</div>';
			echo '</li>';
			
		endwhile;
		
			else:  //No Endorse Heads...Sad Face.
				echo 'There are no Endorse Heads at this time :( ';
				
			endif;
		echo '</ul>';
		/* Restore original Post Data 
		 */
		wp_reset_postdata();
	}

	 /**
	 * Displays the Endorse Head Pic Name.
	 *
	 * @since 	  1.0.0
	 */
	private function endorse_head_pic(){
		
		the_post_thumbnail(array(100,100) , array('class' => 'img-circle'));
	
	}

	/**
	 * Displays The Endorsers Title
	 *
	 * @since	  1.0.0
	 */
	 private function get_endorser_title(){
		
		global $postID, $prefix;
		
		$key = $prefix .'endorser_title';
		$endorserTitle = get_post_meta( $postID, $key, true);
		
		echo '<h6>'.$endorserTitle .'</h6>'; 
	 }

	 /**
	 * Displays the Endorsers Business Name.
	 *
	 * @since 	  1.0.0
	 */
	private function get_business_name($removeClass = false){
		
		global $postID, $prefix;
		
		$key = $prefix.'business_name';
		$businessName = get_post_meta( $postID, $key, true );
		
		if (!$removeClass){
		echo '<h6 class="endorser-business"><small>'.$businessName .'</small><h6>';
		}
		else
			echo '<h6>'.$businessName.'</h6>';
	}
	
	 /**
	 * Displays the Endorsers Quote.
	 *
	 * @since 	  1.0.0
	 */	
	 private function get_quote(){
		
		global $postID, $prefix;
		
		$key = $prefix .'endorser_quote';
		
		$endorserQuote = get_post_meta( $postID, $key, true );

		echo '<p class="endorser-quote">"</span>'.$endorserQuote .'"</p>';		 
	 }
	 
	 /**
	 * The Boring Endorser Loop :)
	 *
	 * @since 	  1.0.0
	 */
	  public function non_endorse_heads_loop() {
		  
		  	//Setup the args
		$args_no_heads = array(
			'post_type' => 'tennis_endorsement',  //query the endorsements post type
			'meta_key' => 'i4_endorser_display',  //query the Endorser Heads
			'meta_value' => 'Normal Listing'
		);
		$query_no_heads = new WP_Query( $args_no_heads );
		
		// The Loop
		echo '<table class="table table-striped">';
		
		echo '<thead>
			  <tr>
			   <td>Name</td>
			   <td>Business</td>';
		echo '</tr>
			  </thead>';
		
		echo '<tbody>';
		
		if ($query_no_heads->have_posts()) :  //Make sure there are Endorse Heads
		
		while ( $query_no_heads->have_posts() ) : $query_no_heads->the_post(); 
			
			global $postID;  //Setup Global Variable for Post ID
			$postID = get_the_ID(); //grab the Post ID
			

					
			//Display The Endorsers Name
			echo '<tr>
				  <td><b>' .get_the_title() .'</b> </td>
				  <td>';
			echo $this->get_business_name(true);
			echo '</td>
				  </tr>';
			//Display The Endorsers Title
			//$this->get_endorser_title();
			
						
		endwhile;
		
			else:  //No Endorse Heads...Sad Face.
				echo 'There are no Endorse Heads at this time :( ';
				
			endif;
		echo '</tbody>
     		  </table>';
		/* Restore original Post Data 
		 */
		wp_reset_postdata();		
		  
	  }
	 
	

}

	global $i4_endorse_heads;
	$i4_endorse_heads = new Endorse_Heads_Frontend();
	
	
	if ( !function_exists( 'endorse_heads_display' ) ) {
	
		/**
		 * Template tag for displaying the Endorse Heads.
		 *
		 * @param string $before  What to show before the breadcrumb.
		 * @param string $after   What to show after the breadcrumb.
		 * @param bool   $display Whether to display the breadcrumb (true) or return it (false).
		 * @return string
		 */
		function endorse_heads_display( ) {
			global $i4_endorse_heads;
			
			return $i4_endorse_heads->endorse_heads_loop();
		}
	}
	
	if ( !function_exists( 'non_endorse_heads_display' ) ) {
	
		/**
		 * Template tag for displaying the Endorsement Listing With No Pictures.
		 *
		 * @param string $before  What to show before the breadcrumb.
		 * @param string $after   What to show after the breadcrumb.
		 * @param bool   $display Whether to display the breadcrumb (true) or return it (false).
		 * @return string
		 */
		function non_endorse_heads_display( ) {
			global $i4_endorse_heads;
			
			return $i4_endorse_heads->non_endorse_heads_loop();
		}
	}	


?>