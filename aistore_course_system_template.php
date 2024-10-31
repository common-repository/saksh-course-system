<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage aistore
 * @since 1.0.0
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();
	

?>
 

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php // twenty_twenty_one_post_thumbnail(); ?>
	</header>

	<div class="entry-content">
		
     
 <?php $meta = get_post_meta(get_the_ID() );
 ?>
 <div class="short_title><p><?php
 echo html_entity_decode(wp_specialchars_decode($meta['short_title'][0]));?>
 </p></div>
 

  
   <div class="course_price">
 <?php
 _e( 'Price', 'aistore' ); ?> <?php
  echo "<strong>".wp_specialchars_decode($meta['course_price'][0])."</strong>";
?>  </div>

    <div class="access">
 <?php
 _e( 'Full life time Access', 'aistore' ); ?> <?php
  echo "<strong>".wp_specialchars_decode($meta['access'][0])."</strong>";
?>  </div>

   <div class="certificate_of_completion">
 <?php
 _e( 'Certificate of Completion', 'aistore' ); ?> <?php
  echo "<strong>".wp_specialchars_decode($meta['certificate_of_completion'][0])."</strong>";
?>  </div>



<div class="course_buy_link"> 
<a href="<?php echo wp_specialchars_decode($meta['course_buy_link'][0]);?>"><input class="input" type="submit" name="submit" value="<?php  _e( 'Buy Now', 'aistore' ) ?>"/></a>
 </p></div>
 
    <div class="description">
 <?php
  _e( 'Description', 'aistore' ); ?> <?php
  echo ":<br>".html_entity_decode(wp_specialchars_decode($meta['description'][0]));
?>  </div>
 
     <div class="topic_covered">
 <?php
  _e( 'Topic Covered', 'aistore' ); ?> <?php
  echo ":<br>".html_entity_decode(wp_specialchars_decode($meta['topic_covered'][0]));
?>  </div>
 

    <div class="requirements">
 <?php
  _e( 'Requirements', 'aistore' ); ?> <?php
  echo ":<br>".html_entity_decode(wp_specialchars_decode($meta['requirements'][0]));
?>  </div>
 

   <div class="curriculum">
 <?php
  _e( 'Curriculum', 'aistore' ); ?> <?php
  echo ":<br>".html_entity_decode(wp_specialchars_decode($meta['curriculum'][0]));
?>  </div>
 

   <div class="about_this_course">
 <?php
  _e( 'About', 'aistore' ); ?> <?php
  echo ":<br>".html_entity_decode(wp_specialchars_decode($meta['about_this_course'][0]));
?>  </div>

   <div class="notes">
 <?php
  _e( 'Notes', 'aistore' ); ?> <?php
  echo ":<br>".html_entity_decode(wp_specialchars_decode($meta['notes'][0]));
?>  </div>
 
 
  <div class="resources">
 <?php
  _e( 'Resources', 'aistore' ); ?> <?php
  echo ":<br>".html_entity_decode(wp_specialchars_decode($meta['resources'][0]));
?>  </div>
 

 

		<div class="course_buy_link">
		    <a href="<?php echo wp_specialchars_decode($meta['course_buy_link'][0]);?>"><input class="input" type="submit" name="submit" value="<?php  _e( 'Buy Now', 'aistore' ) ?>"/></a>
		</div>
	</div><!-- .entry-content -->

 

</article><!-- #post-${ID} -->
<?php
	
	
  
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}

  
  
endwhile; // End of the loop.

get_footer();
