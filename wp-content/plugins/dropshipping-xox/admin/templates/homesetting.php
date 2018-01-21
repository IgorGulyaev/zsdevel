<?php
function dropshix_section_developers_cb( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'dropshix' ); ?></p>
    <?php
}

function dropshix_field_pill_cb( $args ) {
    $options = get_option( 'dropshix_opt' );
    ?>
    <input type="Text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['dropshix_custom_data'] ); ?>"
    class="<?php echo esc_attr( $args['class'] ); ?>"
    name="dropshix_opt[<?php echo esc_attr( $args['label_for'] ); ?>]"
    value="<?php echo isset( $options[ $args['label_for'] ] ) ? ($options[ $args['label_for'] ]) : ( '' ); ?>"
    >
    <?php
}

function dropshix_field_pill_cb2( $args ) {
    $options = get_option( 'dropshix_opt' );
    ?>
    <input type="Text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['dropshix_custom_data'] ); ?>"
    class="<?php echo esc_attr( $args['class'] ); ?>"
    name="dropshix_opt[<?php echo esc_attr( $args['label_for'] ); ?>]"
    value="<?php echo isset( $options[ $args['label_for'] ] ) ? ($options[ $args['label_for'] ]) : ( '' ); ?>"
    >
    <?php
}

function dropshix_field_pill_cb3( $args ) {
    $options = get_option( 'dropshix_opt_mp' );
    ?>
    <input type="Text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['dropshix_custom_data'] ); ?>"
    class="<?php echo esc_attr( $args['class'] ); ?>"
    name="dropshix_opt_mp[<?php echo esc_attr( $args['label_for'] ); ?>]"
    value="<?php echo isset( $options[ $args['label_for'] ] ) ? ($options[ $args['label_for'] ]) : ( '' ); ?>"
    >
    <?php
}

function dropshix_field_pill_cb4( $args ) {
    $options = get_option( 'dropshix_opt_mp' );
    ?>
    <input type="Text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
    data-custom="<?php echo esc_attr( $args['dropshix_custom_data'] ); ?>"
    class="<?php echo esc_attr( $args['class'] ); ?>"
    name="dropshix_opt_mp[<?php echo esc_attr( $args['label_for'] ); ?>]"
    value="<?php echo isset( $options[ $args['label_for'] ] ) ? ($options[ $args['label_for'] ]) : ( '' ); ?>"
    >
    <?php
}

function dropshix_section_dev_cb( $args ) {
    ?>
    
    <?php
}

function dropshix_section_dev_api_ali_cb( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>">
    	How to get API from AliExpress ?<br> 
        please visit the documentation <a target="_BLANK" href="https://portals.aliexpress.com/" >here.</a>
    </p>
    <?php
}