<?php
/**
 * @package foodica
 */

/**
 * Add sections and controls to the customizer.
 */
function foodica_customizer_add_sections_and_options( $wp_customize ) {

    $wp_customize->add_section( 'foodica_lite_homepage_layout', array(
        'title' => __( 'Theme Layout', 'foodica' ),
        'priority' => 50,
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_section( 'foodica_lite_footer_layout', array(
        'title' => __( 'Footer Layout', 'foodica' ),
        'priority' => 50,
        'capability' => 'edit_theme_options',
    ) );

    $wp_customize->add_setting( 'footer-background-color', array(
        'default' => '#EFF4F7',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_setting( 'front-page-layout', array(
        'default' => 'right-sidebar',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'single-post-layout', array(
        'default' => 'right-sidebar',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'single-page-layout', array(
        'default' => 'right-sidebar',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'archives-layout', array(
        'default' => 'full-width',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_setting( 'footer-layout', array(
        'default' => '4',
        'sanitize_callback' => 'sanitize_text_field',
    ) );


    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'footer-background-color',
        array(
            'label' => __( 'Footer Menu Background Color', 'foodica' ),
            'description' => __( '<span style="display:block; background: #eff4f7; border-radius: 5px;padding:10px; border:2px solid #2497d4;">🎨 There are 73 more color & font options in <strong>Foodica PRO</strong> <br/><br/>👉<strong><a href="'. esc_url(__('https://www.wpzoom.com/wordpress-food-themes/foodica-pro/?utm_campaign=foodica_lite_btn', 'foodica')) .'" target="_blank">Unlock all customizations</a></strong></span><br/>', 'foodica' ),
            'priority' => 0,
            'section' => 'colors',
            'settings' => 'footer-background-color'
        )
    ) );

    $wp_customize->add_control(
        'front-page-layout',
        array(
            'label'          => esc_html__( 'Homepage Layout', 'foodica' ),
            'priority'       => 30,
            'section'        => 'foodica_lite_homepage_layout',
            'type'           => 'select',
            'choices'        => array(
                'left-sidebar'  => 'Left Sidebar',
                'full-width'    => 'Full Width',
                'right-sidebar' => 'Right Sidebar',
            )
        )
    );

    $wp_customize->add_control(
        'archives-layout',
        array(
            'label'          => esc_html__( 'Archive Pages Layout (Categories)', 'foodica' ),
            'priority'       => 30,
            'section'        => 'foodica_lite_homepage_layout',
            'type'           => 'select',
            'choices'        => array(
                'left-sidebar'  => 'Left Sidebar',
                'full-width'    => 'Full Width',
                'right-sidebar' => 'Right Sidebar',
            )
        )
    );

    $wp_customize->add_control(
        'single-post-layout',
        array(
            'label'          => esc_html__( 'Single Posts Layout', 'foodica' ),
            'priority'       => 30,
            'section'        => 'foodica_lite_homepage_layout',
            'type'           => 'select',
            'choices'        => array(
                'left-sidebar'  => 'Left Sidebar',
                'full-width'    => 'Full Width',
                'right-sidebar' => 'Right Sidebar',
            )
        )
    );

    $wp_customize->add_control(
        'single-page-layout',
        array(
            'label'          => esc_html__( 'Single Pages Layout', 'foodica' ),
            'priority'       => 30,
            'section'        => 'foodica_lite_homepage_layout',
            'type'           => 'select',
            'choices'        => array(
                'left-sidebar'  => 'Left Sidebar',
                'full-width'    => 'Full Width',
                'right-sidebar' => 'Right Sidebar',
            )
        )
    );

    $wp_customize->add_control(
        'footer-layout',
        array(
            'label'          => esc_html__( 'Footer Widget Areas', 'foodica' ),
            'priority'       => 30,
            'section'        => 'foodica_lite_footer_layout',
            'type'           => 'select',
            'choices'        => array(
                '1'  => '1 Column',
                '2'  => '2 Columns',
                '3'  => '3 Columns',
                '4'  => '4 Columns',
            )
        )
    );
}
add_action( 'customize_register', 'foodica_customizer_add_sections_and_options' );

/**
 * Print customizer css.
 */
function foodica_customizer_display_css() {
    $styles = array();

    if ( '#EFF4F7' != ( $header_background_color = get_theme_mod( 'footer-background-color', '#EFF4F7' ) ) ) {
        $styles[] = array(
            'selectors' => '.footer-menu',
            'declarations' => array(
                'background-color' => $header_background_color
            )
        );
    }

    if ( empty( $styles ) ) return;
    ?>

    <style type="text/css">

        <?php
        foreach ( $styles as $rule ) {
            echo $rule['selectors'] . ' {';

            foreach ( $rule['declarations'] as $property => $value ) {
                $value = esc_attr($value);
                echo "{$property}:{$value};\n";
            }

            echo '}';
        }
        ?>

    </style>

    <?php
}
add_action( 'wp_head', 'foodica_customizer_display_css', 20 );
