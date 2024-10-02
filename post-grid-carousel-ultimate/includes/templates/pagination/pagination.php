<!-- .pgcu-pagination--left/.pgcu-pagination--right -->
<div class="pgcu-pagination" style="
    --pgcu-pagColor: <?php echo esc_attr( $pagi_color ); ?>;
    --pgcu-pagColorHover: <?php echo esc_attr( $pagi_hover_color ); ?>;
    --pgcu-pagBorderColor: <?php echo esc_attr( $pagi_border_color ); ?>;
    --pgcu-pagBorderColorHover: <?php echo esc_attr( $pagi_hover_border_color ); ?>;
    --pgcu-pagBgColor: <?php echo esc_attr( $pagi_back_color ); ?>;
    --pgcu-pagBgColorHover: <?php echo esc_attr( $pagi_hover_back_color ); ?>;
    --pgcu-pagActiveColor: <?php echo esc_attr( $pagi_active_color ); ?>;
    --pgcu-pagActiveBorderColor: <?php echo esc_attr( $pagi_active_border_color ); ?>;
    --pgcu-pagActiveBgColor: <?php echo esc_attr( $pagi_active_back_color ); ?>;
">
    <?php
    echo pgcu_pagination( $posts, $paged );
    ?>
</div>