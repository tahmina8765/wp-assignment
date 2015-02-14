<?php

/**
 * Adds Foo_Widget widget.
 */
class Banner_Widget extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(
                'banner_widget', // Base ID
                'Banner Widget', // Name
                array ('description' => __('A Banner Widget', 'text_domain'),) // Args
        );

    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        extract($args);
        $title  = apply_filters('widget_title', $instance['title']);
        $banner = apply_filters('widget_banner', $instance['banner']);

        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        $image_attributes = wp_get_attachment_image_src($banner);
        if ($image_attributes) {
            ?>
            <img src="<?php echo $image_attributes[0]; ?>" width="<?php echo $image_attributes[1]; ?>" height="<?php echo $image_attributes[2]; ?>">
        <?php
        }
        echo $after_widget;

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
        $instance           = array ();
        $instance['title']  = strip_tags($new_instance['title']);
        $instance['banner'] = strip_tags($new_instance['banner']);

        return $instance;

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
        $title  = __('New title', 'text_domain');
        $banner = 'Select an image id';
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        if (isset($instance['banner'])) {
            $banner = $instance['banner'];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('banner'); ?>"><?php _e('Banner Image:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('banner'); ?>" name="<?php echo $this->get_field_name('banner'); ?>" type="text" value="<?php echo esc_attr($banner); ?>" />
        </p>
        <?php

    }

}

// class Banner_Widget


function init_banner_widget()
{
    register_widget("Banner_Widget");

}

add_action("widgets_init", "init_banner_widget");
