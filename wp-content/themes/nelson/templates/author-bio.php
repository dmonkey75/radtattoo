<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage NELSON
 * @since NELSON 1.0
 */
?>

<div class="author_info author vcard" itemprop="author" itemscope="itemscope" itemtype="<?php echo esc_attr( nelson_get_protocol( true ) ); ?>//schema.org/Person">

    <?php $nelson_mult = nelson_get_retina_multiplier(); ?>

    <div class="author_avatar <?php echo nelson_add_inline_css_class( 'background-image: url(' . esc_url(
            get_avatar_url(
                get_the_author_meta( 'user_email' ), array('size' => (600 * $nelson_mult) )
            )
        ) . ');' ); ?>">

    </div><!-- .author_avatar -->

	<div class="author_description">
		<h4 class="author_title" itemprop="name">
		<?php
			// Translators: Add the author's name in the <span>
			echo wp_kses_data( sprintf( __( '%s', 'nelson' ), '<span class="fn">' . get_the_author() . '</span>' ) );
		?>
		</h4>

		<div class="author_bio" itemprop="description">
			<?php echo wp_kses( wpautop( get_the_author_meta( 'description' ) ), 'nelson_kses_content' ); ?>
			<a class="author_link sc_button sc_button_simple" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                        <?php
                        // Translators: Add the author's name in the <span>
                        echo esc_html__( 'Read more', 'nelson' );
                        ?>
			</a>
			<?php do_action( 'nelson_action_user_meta' ); ?>
		</div><!-- .author_bio -->

	</div><!-- .author_description -->

</div><!-- .author_info -->
