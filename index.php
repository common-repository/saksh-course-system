<?php

/*
Plugin Name: Saksh Course System
Version:  1.0
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Saksh course pluign is best if you sell courses from your website and don't wish to install any big learning management system as it may cost huge load on your worpdress installation.


*/


 $mce_buttons = array(
                    'formatselect',
                    'bold',
                    'italic',
                    'bullist',
                    'numlist',
                    'blockquote',
                    'alignleft',
                    'aligncenter',
                    'alignright',
                    'link',
                    'wp_more',
                    'spellchecker',
                );
				

  $mce_buttons_2 = array(
                    'strikethrough',
                    'hr',
                    'forecolor',
                    'pastetext',
                    'removeformat',
                    'charmap',
                    'outdent',
                    'indent',
                    'undo',
                    'redo',
                );
				
	global $settings;
	
    $settings = [
        'tinymce' => [
            'toolbar1' =>
                'bold,italic,underline,separator,alignleft,aligncenter,alignright ,removeformat  ',
            
				   'toolbar2'          => implode( ',', $mce_buttons ),
                'toolbar3'          => implode( ',', $mce_buttons_2 ),
        ],
        'textarea_rows' => 1,
        'teeny' => true,
        'quicktags' => false,
           'paste_remove_styles' => true,
        'paste_remove_spans' => true,
        'media_buttons' => false,
    ];
    

add_action('init', 'SCS_aistore_load_language');

function SCS_aistore_load_language()
{
    load_plugin_textdomain(
        'aistore',
        false,
        basename(dirname(__FILE__)) . '/languages/'
    );
}

add_filter('single_template', 'SCS_aistore_template');

function SCS_aistore_template($single)
{
    global $post;

    $dir = plugin_dir_path(__FILE__);
    /* Checks for single template by post type */
    if ($post->post_type == 'courses') {
        return $dir . 'aistore_course_system_template.php';
    }
}

function SCS_aistore_save_meta_box_data($post_id)
{
    // Check if our nonce is set.
    if (!isset($_POST['aistore_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['aistore_nonce'], 'aistore_nonce')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return;
        }
    } else {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    }

 
 
   
    $short_title = sanitize_text_field(stripslashes(htmlentities($_POST['short_title'])));
    
    update_post_meta($post_id, 'short_title', $short_title);
    



    $course_buy_link = esc_url_raw($_POST['course_buy_link']);
    
    update_post_meta($post_id, 'course_buy_link', $course_buy_link);
    
    
    
    $course_price = intval( $_POST['course_price'] );
    if ( ! $course_price ) {
      $course_price = 0;
    }
    
  
    update_post_meta($post_id, 'course_price', $course_price);
    
    
    
    
    $access = sanitize_text_field($_POST['access']);

    update_post_meta($post_id, 'access', $access);
    
    
    
    
    $certificate_of_completion = sanitize_text_field(
       $_POST['certificate_of_completion']
    );
    
    update_post_meta( $post_id,   'certificate_of_completion',   $certificate_of_completion );
    
    
    $description = sanitize_text_field(stripslashes(htmlentities($_POST['description'])));
    
    update_post_meta($post_id, 'description', $description);
    
    
    $topic_covered = sanitize_text_field(stripslashes(htmlentities($_POST['topic_covered'])));
    
    update_post_meta($post_id, 'topic_covered', $topic_covered);
    
    
    
    $requirements = sanitize_text_field(stripslashes(htmlentities($_POST['requirements'])));

    update_post_meta($post_id, 'requirements', $requirements);
    
    
    $curriculum = sanitize_text_field(stripslashes(htmlentities($_POST['curriculum'])));
    
    update_post_meta($post_id, 'curriculum', $curriculum);
    
    
    $about_this_course = sanitize_text_field(
        stripslashes(htmlentities($_POST['about_this_course']))
    );
    
    
    update_post_meta($post_id, 'about_this_course', $about_this_course);
    
    
    
    
    $notes = sanitize_text_field(stripslashes(htmlentities($_POST['notes'])));
    
    update_post_meta($post_id, 'notes', $notes);
    
    
    
    $resources = sanitize_text_field(stripslashes(htmlentities($_POST['resources'])));

    update_post_meta($post_id, 'resources', $resources);
    
    
}

add_action('save_post', 'SCS_aistore_save_meta_box_data');

function SCS_aistore_meta_box_callback($post)
{
    // Add a nonce field so we can check for it later. SCS_aistore_meta_box_callback
    wp_nonce_field('aistore_nonce', 'aistore_nonce');

    // $value = get_post_meta( $post->ID, 'short_title', true );

    
    $course_buy_link = html_entity_decode(
        get_post_meta($post->ID, 'course_buy_link', true)
    );
    $course_price_value = html_entity_decode(
        get_post_meta($post->ID, 'course_price', true)
    );
    $certificate_of_completion_value = html_entity_decode(
        get_post_meta($post->ID, 'certificate_of_completion', true)
    );
    $access_value = html_entity_decode(
        get_post_meta($post->ID, 'access', true)
    );
    ?>
   
  
 <label for="course_buy_link"><?php _e(
     'Course buy link',
     'aistore'
 ); ?></label><br>
  <input class="input" type="text" id="course_buy_link" name="course_buy_link" value="<?php echo $course_buy_link; ?>" required><br>
 
  <br>

  
  <label for="course_price"><?php _e('Course Price', 'aistore'); ?></label><br>
  <input class="input" type="text" id="course_price" name="course_price" value="<?php echo $course_price_value; ?>" required><br>
  <br>
   <label for="access"><?php _e('Full life time access', 'aistore'); ?></label>

<select name="access" id="access">
   <option value="">Select...</option>
            <option value="yes" <?php selected(
                $access_value,
                'yes'
            ); ?>>Yes</option>
            <option value="no" <?php selected(
                $access_value,
                'no'
            ); ?>>No</option>
  
</select> <br><br>

   <label for="certificate_of_completion"><?php _e(
       'Certificate of completion',
       'aistore'
   ); ?></label>

<select name="certificate_of_completion" id="certificate_of_completion">

 <option value="">Select...</option>
            <option value="yes" <?php selected(
                $certificate_of_completion_value,
                'yes'
            ); ?>>Yes</option>
            <option value="no" <?php selected(
                $certificate_of_completion_value,
                'no'
            ); ?>>No</option>

  
</select> <br>

 

    
 <?php $meta = get_post_meta($post->ID);
}

function SCS_aistore_meta_box_callback_shorttitle($post)
{
    $short_title_value = html_entity_decode(
        get_post_meta($post->ID, 'short_title', true)
    );

    $content = $short_title_value;
    $editor_id = 'short_title';

 
global $settings;
	

    wp_editor($content, $editor_id, $settings);
}

function SCS_aistore_meta_box_callback_description($post)
{
    $description_value = html_entity_decode(
        get_post_meta($post->ID, 'description', true)
    );

    $content = $description_value;
    $editor_id = 'description';

 global $settings;
	
    wp_editor($content, $editor_id, $settings);
}

function SCS_aistore_meta_box_callback_topic_coverd($post)
{
    $topic_covered_value = html_entity_decode(
        get_post_meta($post->ID, 'topic_covered', true)
    );

    $content = $topic_covered_value;
    $editor_id = 'topic_covered';


global $settings;
	
 

    wp_editor($content, $editor_id, $settings);
}

function SCS_aistore_meta_box_callback_requirements($post)
{
    $requirements_value = html_entity_decode(
        get_post_meta($post->ID, 'requirements', true)
    );
    $content = $requirements_value;
    $editor_id = 'requirements';

 global $settings;
	

    wp_editor($content, $editor_id, $settings);
}
function SCS_aistore_meta_box_callback_curriculum($post)
{
    $curriculum_value = html_entity_decode(
        get_post_meta($post->ID, 'curriculum', true)
    );

    $content = $curriculum_value;
    $editor_id = 'curriculum';

global $settings;
	

    wp_editor($content, $editor_id, $settings);
}

function SCS_aistore_meta_box_callback_about($post)
{
    $about_this_course_value = html_entity_decode(
        get_post_meta($post->ID, 'about_this_course', true)
    );

    $content = $about_this_course_value;
    $editor_id = 'about_this_course';
global $settings;
	

    wp_editor($content, $editor_id, $settings);
}

function SCS_aistore_meta_box_callback_notice($post)
{
    $notes_value = html_entity_decode(get_post_meta($post->ID, 'notes', true));

    $content = $notes_value;
    $editor_id = 'notes';

   global $settings;
	

    wp_editor($content, $editor_id, $settings);
}

function SCS_aistore_meta_box_callback_resources($post)
{
    $resources_value = html_entity_decode(
        get_post_meta($post->ID, 'resources', true)
    );

    $content = $resources_value;
    $editor_id = 'resources';

   global $settings;
	

    wp_editor($content, $editor_id, $settings);
}

function SCS_aistore_meta_box()
{
    $screens = [ 'courses'];

    foreach ($screens as $screen) {
        add_meta_box(
            'aistore_course',
            __('Course', 'aistore'),
            'SCS_aistore_meta_box_callback',
            $screen
        );

        add_meta_box(
            'aistore_shorttitle',
            __('Short Title', 'aistore'),
            'SCS_aistore_meta_box_callback_shorttitle',
            $screen
        );

        add_meta_box(
            'aistore_description',
            __('Description', 'aistore'),
            'SCS_aistore_meta_box_callback_description',
            $screen
        );

        add_meta_box(
            'aistore_topic_coverd',
            __('Topic Coverd', 'aistore'),
            'SCS_aistore_meta_box_callback_topic_coverd',
            $screen
        );

        add_meta_box(
            'aistore_requirements',
            __('Requirements', 'aistore'),
            'SCS_aistore_meta_box_callback_requirements',
            $screen
        );

        add_meta_box(
            'aistore_curriculum',
            __('Curriculum', 'aistore'),
            'SCS_aistore_meta_box_callback_curriculum',
            $screen
        );

        add_meta_box(
            'aistore_about',
            __('About', 'aistore'),
            'SCS_aistore_meta_box_callback_about',
            $screen
        );

        add_meta_box(
            'aistore_notice',
            __('Notes', 'aistore'),
            'SCS_aistore_meta_box_callback_notice',
            $screen
        );

        add_meta_box(
            'aistore_resources',
            __('Resources', 'aistore'),
            'SCS_aistore_meta_box_callback_resources',
            $screen
        );
    }
}

add_action('add_meta_boxes', 'SCS_aistore_meta_box');

function SCS_aistore_custom_post_type()
{
    // Set UI labels for Custom Post Type
    $labels = [
        'name' => _x('Courses', 'Post Type General Name', 'aistore'),
        'singular_name' => _x('Course', 'Post Type Singular Name', 'aistore'),
        'menu_name' => __('Courses', 'aistore'),
        'parent_item_colon' => __('Parent Course', 'aistore'),
        'all_items' => __('All Courses', 'aistore'),
        'view_item' => __('View Course', 'aistore'),
        'add_new_item' => __('Add New Course', 'aistore'),
        'add_new' => __('Add New', 'aistore'),
        'edit_item' => __('Edit Course', 'aistore'),
        'update_item' => __('Update Course', 'aistore'),
        'search_items' => __('Search Course', 'aistore'),
        'not_found' => __('Not Found', 'aistore'),
        'not_found_in_trash' => __('Not found in Trash', 'aistore'),
    ];

    // Set other options for Custom Post Type

    $args = [
        'label' => __('courses', 'aistore'),
        'description' => __('Course news and reviews', 'aistore'),
        'labels' => $labels,
        // Features this CPT supports in Post Editor
        'supports' => [
            'title',
            'excerpt',
            'author',
            'thumbnail',
            'comments',
            'revisions',
           'taxonomies' => array( 'tags' ,  'languages' ,'exams' ,'subjects' ),
        ],

        /* A hierarchical CPT is like Pages and can have
         * Parent and child items. A non-hierarchical CPT
         * is like Posts.
         */
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => false,
    ];

    // Registering your Custom Post Type
    register_post_type('courses', $args);
}

/* Hook into the 'init' action so that the function
 * Containing our post type registration is not
 * unnecessarily executed.
 */

add_action('init', 'SCS_aistore_custom_post_type', 0);


//hook into the init action and call aistore_create_subjects_hierarchical_taxonomy when it fires
 
add_action( 'init', 'SCS_aistore_create_subjects_hierarchical_taxonomy', 0 );
 
//create a custom taxonomy name it subjects for your posts
 
function SCS_aistore_create_subjects_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
 
  $labels = array(
    'name' => _x( 'Subjects', 'taxonomy general name' ),
    'singular_name' => _x( 'Subject', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Subjects' ),
    'all_items' => __( 'All Subjects' ),
    'parent_item' => __( 'Parent Subject' ),
    'parent_item_colon' => __( 'Parent Subject:' ),
    'edit_item' => __( 'Edit Subject' ), 
    'update_item' => __( 'Update Subject' ),
    'add_new_item' => __( 'Add New Subject' ),
    'new_item_name' => __( 'New Subject Name' ),
    'menu_name' => __( 'Subjects' ),
  );    
 
 
// Now register the taxonomy
  register_taxonomy('subjects',array('courses'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'subject' ),
  ));
 
}


//hook into the init action and call aistore_create_exam_hierarchical_taxonomy when it fires
 
add_action( 'init', 'SCS_aistore_create_exam_hierarchical_taxonomy', 0 );
 
//create a custom taxonomy name it subjects for your posts
 
function SCS_aistore_create_exam_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
 
  $labels = array(
    'name' => _x( 'Exam', 'taxonomy general name' ),
    'singular_name' => _x( 'Exam', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Exams' ),
    'all_items' => __( 'All Exams' ),
    'parent_item' => __( 'Parent Exam' ),
    'parent_item_colon' => __( 'Parent Exam:' ),
    'edit_item' => __( 'Edit Exam' ), 
    'update_item' => __( 'Update Exam' ),
    'add_new_item' => __( 'Add New Exam' ),
    'new_item_name' => __( 'New Exam Name' ),
    'menu_name' => __( 'Exams' ),
  );    
 

// Now register the taxonomy
  register_taxonomy('exams',array('courses'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'exams' ),
  ));
 
}





//hook into the init action and call aistore_create_language_hierarchical_taxonomy when it fires
 
add_action( 'init', 'SCS_aistore_create_language_hierarchical_taxonomy', 0 );
 
//create a custom taxonomy name it subjects for your posts
 
function SCS_aistore_create_language_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI  


 
  $labels = array(
    'name' => _x( 'Language', 'taxonomy general name' ),
    'singular_name' => _x( 'Language', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Languages' ),
    'all_items' => __( 'All Languages' ),
    'parent_item' => __( 'Parent Language' ),
    'parent_item_colon' => __( 'Parent Language:' ),
    'edit_item' => __( 'Edit Language' ), 
    'update_item' => __( 'Update Language' ),
    'add_new_item' => __( 'Add New Language' ),
    'new_item_name' => __( 'New Language Name' ),
    'menu_name' => __( 'Languages' ),
  );    
 
// Now register the taxonomy
  register_taxonomy('languages',array('courses'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'language' ),
  ));
 
}






//hook into the init action and call aistore_create_tags_hierarchical_taxonomy when it fires
 
add_action( 'init', 'SCS_aistore_create_tags_hierarchical_taxonomy', 0 );
 
//create a custom taxonomy name it subjects for your posts
 
function SCS_aistore_create_tags_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
 
  $labels = array(
    'name' => _x( 'Tag', 'taxonomy general name' ),
    'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Tags' ),
    'all_items' => __( 'All Tags' ),
    'parent_item' => __( 'Parent Tag' ),
    'parent_item_colon' => __( 'Parent Tag' ),
    'edit_item' => __( 'Edit Tag' ), 
    'update_item' => __( 'Update Tag' ),
    'add_new_item' => __( 'Add New Tag' ),
    'new_item_name' => __( 'New Tag Name' ),
    'menu_name' => __( 'Tags' ),
  );    
 
// Now register the taxonomy
  register_taxonomy('tags',array('courses'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'tags' ),
  ));
 
}





function my_format_TinyMCE( $in ) {
	$in['remove_linebreaks'] = false;
	$in['gecko_spellcheck'] = false;
	$in['keep_styles'] = true;
	$in['accessibility_focus'] = true;
	$in['tabfocus_elements'] = 'major-publishing-actions';
	$in['media_strict'] = false;
	$in['paste_remove_styles'] = false;
	$in['paste_remove_spans'] = false;
	$in['paste_strip_class_attributes'] = 'none';
	$in['paste_text_use_dialog'] = true;
	$in['wpeditimage_disable_captions'] = true;
	$in['plugins'] = 'tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen';
	$in['content_css'] = get_template_directory_uri() . "/editor-style.css";
	$in['wpautop'] = true;
	$in['apply_source_formatting'] = false;
        $in['block_formats'] = "Paragraph=p; Heading 3=h3; Heading 4=h4";
	$in['toolbar1'] = 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv ';
	$in['toolbar2'] = 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help ';
	$in['toolbar3'] = '';
	$in['toolbar4'] = '';
	return $in;
}
add_filter( 'tiny_mce_before_init', 'my_format_TinyMCE' );


