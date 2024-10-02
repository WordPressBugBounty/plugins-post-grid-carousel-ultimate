<?php
if( ! empty( $_GET['pgcu-dismiss-notice'] ) && 'true' == $_GET['pgcu-dismiss-notice'] ) {
    update_option( 'pgcu_dismiss_notice', true );
}

if( ! isset( $_GET['pgcu-dismiss-notice'] ) ) { ?>

    <div class="pgcu-dashboard-notice">
        <p>
        <?php
            echo wp_kses_post( sprintf(
                /* translators: %s: documentation URL */
                __( 'We are giving away 25 premium licenses to our users for FREE. Claim before it’s gone! To claim <a href="%s" target="_blank">Contact us.</a>', 'post-grid-carousel-ultimate' ),
                'https://wpwax.com/contact'
            ) );
        ?>
        </p>
        <a class="pgcu-dashboard-notice__dismiss" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'pgcu-dismiss-notice', 'true' ) ) ); ?>"><?php esc_html_e( 'Dismiss', 'post-grid-carousel-ultimate' ); ?></a>
    </div>

<?php } ?>
