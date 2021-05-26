<?php

namespace Trykoszko\Widgets;

/**
 * A widget that displays User's daily activity idea
 */
class UserActivity extends \WP_Widget
{

    protected $twig;
    protected $dataProvider;

    public function __construct(
        \Trykoszko\Twig\Main $twig,
        \Trykoszko\DataProvider\Main $dataProvider
    )
    {
        parent::__construct(
            'foo_widget',
            esc_html__('User Activity Widget', TEXTDOMAIN),
            array('description' => esc_html__('User Activity Widget', TEXTDOMAIN),)
        );

        $this->twig = $twig;
        $this->dataProvider = $dataProvider;
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
        if (is_user_logged_in()) {
            $activity = $this->dataProvider->getUserActivity(get_current_user_id());
            if ($activity) {
                echo $args['before_widget'];
                if (!empty($instance['title'])) {
                    echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
                }
                $this->twig->render('widget_user_activity', [
                    'activity' => $activity
                ]);
                echo $args['after_widget'];
            }
        }
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
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('New title', TEXTDOMAIN);

        $this->twig->render('widget_user_activity_admin', [
            'fieldId' => esc_attr($this->get_field_id('title')),
            'fieldName' => esc_attr($this->get_field_name('title')),
            'fieldLabel' => esc_attr('Title:', TEXTDOMAIN),
            'fieldValue' => esc_attr($title)
        ]);
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
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';

        return $instance;
    }
}
