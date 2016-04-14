<?php
//register widgetS
function register_sp_widget() {
    register_widget( 'sp_Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'register_sp_widget' );

/**
 * Add sp_Recent_Posts_Widget widget.
 */
class sp_Recent_Posts_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'sp_recent_posts', // Base ID
            'SassaPress Recent Posts', // Name
            array( 'description' => __( 'Recent Posts Widget', SPTEXTDOMAIN ), ) // Args
            );
    }

    public function widget( $args, $instance ) {
        $title  = $instance['title'];
        $count  = $instance['count'];
        echo $args['before_widget'];
        echo $args['before_title'] . $title . $args['after_title'];

        $posts = get_posts( array( 'numberposts' => $count ) );
        foreach ($posts as $key => $value) {
            ?>
            <div class="media">
                <div class="pull-left">
                    <a href="<?php echo get_permalink( $value->ID ); ?>"><?php echo get_the_post_thumbnail( $value->ID, array(64,64) ); ?></a>
                </div>
                <div class="media-body">
                    <span class="media-heading"><a href="<?php echo get_permalink( $value->ID ); ?>"><?php echo $value->post_title; ?></a></span><br>
                    <?php echo date( 'F d, Y', strtotime($value->post_date) ); ?>
                </div>
            </div>
            <?php }
            echo $args['after_widget'];
        }

        public function form( $instance ) {
            $title  = isset($instance[ 'title' ]) ? $instance[ 'title' ] : 'Recent Posts';
            $count  = isset($instance[ 'count' ]) ? $instance[ 'count' ] : 3;
            ?>
            <p>
                <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:', SPTEXTDOMAIN ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_name( 'count' ); ?>"><?php _e( 'Number of posts:', SPTEXTDOMAIN ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
            </p>
            <?php 
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
            return $instance;
        }


    }


/**
* Add SassaPress Ads Widget widget.
*/

function sp_AD_Scripts(){
  wp_enqueue_media();
  wp_enqueue_script('adsScript', get_template_directory_uri() . '/assets/js/upload.js');
}
add_action('admin_enqueue_scripts', 'sp_AD_Scripts');


function sp_AD_Widget() {
    register_widget( 'sp_AD_Widget' );
}
add_action( 'widgets_init', 'sp_AD_Widget' );

class sp_AD_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'sp_ad', // Advertisement
            'Advertisement',
            array( 'description' => __( 'Display Advertise image with link.', SPTEXTDOMAIN ), ) // Args
            );
    }

    public function widget( $args, $instance ) {
        $url  = $instance['url'];
        $url2  = $instance['url2'];
        $img_src  = $instance['img_src'];
        $img_src2  = $instance['img_src2'];
        echo $args['before_widget'];   
            //echo $args['before_title'] . $title . $args['after_title'];
        ?>
        <div class="widget ads">
            <div class="row">
                <div class="col-xs-6">
                    <?php $urls = esc_url($instance['url']);
                    $images = esc_url($instance['img_src']);
                    if( $urls || $images) { 
                        ?>
                        <a class="img-responsive img-rounded" href="<?php echo $urls; ?>" target="_blank"><img class="img-responsive img-rounded" src="<?php echo $images; ?>" class="img-thumbnail"/></a>
                        <?php } else{
                            ?>
                            <a class="img-responsive img-rounded" href="#" target="_blank"><img class="img-responsive img-rounded" src="<?php echo get_template_directory_uri(); ?>/assets/images/ad2.jpg" class="img-thumbnail"/></a>
                            <?php } ?>

                            
                        </div>

                        <div class="col-xs-6">
                            <?php $urls2 = esc_url($instance['url2']);
                            $images2 = esc_url($instance['img_src2']);
                            if( $urls2 || $images2) { 
                                ?>
                                <a href="<?php echo esc_url($instance['url2']); ?>" target="_blank"><img class="img-responsive img-rounded" src="<?php echo esc_url($instance['img_src2']); ?>" class="img-thumbnail"/></a>
                                <?php } else{
                                    ?>
                                    <a class="img-responsive img-rounded" href="#" target="_blank"><img class="img-responsive img-rounded" src="<?php echo get_template_directory_uri(); ?>/assets/images/ad2.jpg" class="img-thumbnail"/></a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <?php
                        echo $args['after_widget'];
                    }

                    public function form( $instance ) {
           /* $img_id = $this->get_field_id('img_src'); 
            $img_id2 = $this->get_field_id('img_src2'); 
            $url  = $instance['url'];
            $url2  = $instance['url2'];
            $img_src = $instance['img_src'];
            $img_src2 = $instance['img_src2'];
            */
            ?>
            <div class="widget-content">
                <p>
                    <label for="<?php echo $this->get_field_id('url'); ?>">URL:</label><br/>
                    <input class="widefat"  type="text" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php if(!empty($instance['url'])){echo $instance['url'];} ?>" />
                </p>

                <label for="<?php echo $this->get_field_id('img_src'); ?>">Image</label><br />
                <?php if(!empty($instance['img_src'])){ ?>
                <img class="custom_media_image" src="<?php echo $instance['img_src'];?>" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" />
                <?php } ?>
                <input type="text" class="widefat custom_media_url" name="<?php echo $this->get_field_name('img_src'); ?>" id="<?php echo $this->get_field_id('img_src'); ?>" value="<?php if(!empty($instance['img_src'])){echo $instance['img_src'];} ?>">
                <a href="#" class="button custom_media_upload"><?php _e('Upload', SPTEXTDOMAIN); ?></a>            

                <p>
                    <label for="<?php echo $this->get_field_id('url2');?>">URL:</label><br/>
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id('url2'); ?>" name="<?php echo $this->get_field_name('url2'); ?>" value="<?php if(!empty($instance['url2'])){echo $instance['url2'];} ?>" />
                </p>

                <label for="<?php echo $this->get_field_id('img_src2'); ?>">Image</label><br />
                <?php if(!empty($instance['img_src2'])){ ?>
                <img class="custom_media_image2" src="<?php if(!empty($instance['img_src2'])){echo $instance['img_src2'];} else{ echo "No Image";}?>" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" />
                <?php } ?>
                <input type="text" class="widefat custom_media_url2" name="<?php echo $this->get_field_name('img_src2'); ?>" id="<?php echo $this->get_field_id('img_src2'); ?>" value="<?php if(!empty($instance['img_src2'])){echo $instance['img_src2'];} ?>">
                <a href="#" class="button custom_media_upload2"><?php _e('Upload', SPTEXTDOMAIN); ?></a>
            </div>
            <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : '';
            $instance['url2'] = ( ! empty( $new_instance['url2'] ) ) ? strip_tags( $new_instance['url2'] ) : '';
            $instance['img_src'] = ( ! empty( $new_instance['img_src'] ) ) ? strip_tags( $new_instance['img_src'] ) : '';
            $instance['img_src2'] = ( ! empty( $new_instance['img_src2'] ) ) ? strip_tags( $new_instance['img_src2'] ) : '';
            $instance['image_uri'] = strip_tags( $new_instance['image_uri'] );
            
            return $instance;
        }

        
    }
?>