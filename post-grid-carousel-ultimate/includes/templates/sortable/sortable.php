<?php if( $terms ) { ?>
<div class="pgcu-post-sortable__nav" style="
    --pgcu-sortableBtnColor: <?php echo esc_attr( $sortable_menu_text_color ); ?>;
    --pgcu-sortableBtnActiveBg: <?php echo esc_attr( $sortable_menu_active_back_color ); ?>;
    --pgcu-sortableBtnActiveColor: <?php echo esc_attr( $sortable_menu_active__text_color ); ?>;
">
    <a href="" class="pgcu-post-sortable__btn pgcu-post-sortable__btn--active" data-sortable-nav="all">All (<?php echo $posts->found_posts; ?>)</a>

    <?php foreach( $terms as $term ) { ?>
        <a class="pgcu-post-sortable__btn" data-query="<?php echo json_encode( $posts->query_vars ); ?>" data-id="<?php echo ! empty( $post_id ) ? $post_id : ''; ?>" data-sortable-nav="<?php echo esc_attr( $term->term_id ); ?>"><?php echo esc_html( $term->name ); ?> (<?php echo $term->count; ?>)</a>
    <?php } ?>

</div>
<?php } ?>
