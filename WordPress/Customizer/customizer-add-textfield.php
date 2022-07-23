$wp_customize->add_setting( 'themeslug_text_setting_id', array(
  'capability' => 'edit_theme_options',
  'default' => 'Lorem Ipsum',
  'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'themeslug_text_setting_id', array(
  'type' => 'text',
  'section' => 'custom_section', // Add a default or your own section
  'label' => __( 'Custom Text' ),
  'description' => __( 'This is a custom text box.' ),
) );