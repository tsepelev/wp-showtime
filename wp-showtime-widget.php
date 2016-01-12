<?php
/*
Plugin Name: WP Showtime Widget
Plugin URI: http://tsepelev.ru/wp-showtime
Description: The widget allows you to view at any place of your theme list of film shows in a certain cinema.
Author: Sergey Tsepelev
Version: 1.0
Author URI: http://tsepelev.ru
*/
// Block direct requests
if (!defined('ABSPATH'))
    die('-1');


add_action('widgets_init', function () {
    register_widget('WP_Showtime');
});

/**
 * Adds My_Widget widget.
 */
class WP_Showtime extends WP_Widget
{
    /**
     * Register widget with WordPress.
     */
    function __construct()
    {
        parent::__construct(
            'WP_Showtime', // Base ID
            __('WP Showtime Widget', 'wp-showtime'), // Name
            array('description' => __('The widget allows you to view at any place of your theme list of film shows in a certain cinema.', 'wp-showtime'),) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        include_once('simple_html_dom.php');
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        if (!empty($instance['id'])) {
            $mid = apply_filters('widget_id', $instance['id']);
            $lang = substr(get_bloginfo('language'), 0, 2);
            $html = @file_get_html('http://www.google.com/movies?hl=' . $lang . '&tid=' . $mid);
            foreach ($html->find('#movie_results .theater') as $div) {
                ?>
                <div>
                    <h3><?php echo iconv('Windows-1251', 'UTF-8', $div->find('h2.name', 0)->plaintext); ?></h3>
                </div>
                <?php
                foreach ($div->find('.movie') as $movie) {
                    ?>
                    <div class="kino" style="border-bottom: solid 1px #e9e9e9; margin-bottom: 20px">
                        <p>
                            <strong><?php echo iconv('Windows-1251', 'UTF-8', $movie->find('.name a', 0)->innertext); ?></strong>
                            <?php echo iconv('Windows-1251', 'UTF-8', $movie->find('.times', 0)->plaintext); ?></p>
                    </div>
                    <?php
                }
            }
        }
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Example: 5ecae14375fa0827', 'wp-showtime');
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-showtime'); ?></label>

            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
        if (isset($instance['id'])) {
            $id = $instance['id'];
        } else {
            $id = __('Example: 5ecae14375fa0827', 'wp-showtime');
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('ID cinema:', 'wp-showtime'); ?></label>

            <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>"
                   name="<?php echo $this->get_field_name('id'); ?>" type="text"
                   value="<?php echo esc_attr($id); ?>">
            <small><?php _e('Go to the address <a href="http://www.google.com/movies">http://www.google.com/movies</a> enter your city and then clicks on the name of the theater, in the address bar will be the parameter that contains the tid want us Id. Copy and paste it in the box above.', 'wp-showtime') ?></small>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['id'] = (!empty($new_instance['id'])) ? strip_tags($new_instance['id']) : '';
        return $instance;
    }
} // class My_Widget
