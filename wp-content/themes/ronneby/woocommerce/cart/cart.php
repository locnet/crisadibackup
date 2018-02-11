<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<div class="cart-wrap">
	<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
		<div class="row">

			<div class="seven columns">
				<?php do_action( 'woocommerce_before_cart_table' ); ?>

				<table class="shop_table cart" cellspacing="0">
					<thead>
						<tr>
							<th class="product-thumbnail">&nbsp;</th>
							<th class="product-name box-name"><?php _e( 'Product', 'dfd' ); ?></th>
							<th class="product-price box-name"><?php _e( 'Price', 'dfd' ); ?></th>
							<th class="product-quantity box-name"><?php _e( 'Quantity', 'dfd' ); ?></th>
							<th class="product-subtotal box-name"><?php _e( 'Total', 'dfd' ); ?></th>
							<th class="product-remove">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?php do_action( 'woocommerce_before_cart_contents' ); ?>

						<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							
							/*compatibility 3.3.0*/
							$remove_link = function_exists('wc_get_cart_remove_url') ? wc_get_cart_remove_url($cart_item_key) : WC()->cart->get_remove_url($cart_item_key);

							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>
								<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

									<td class="product-thumbnail">
										<div class="image-cover">
											<?php
												$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

												if ( ! $product_permalink ) {
													echo $thumbnail;
												} else {
													printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
												}
											?>
										</div>
									</td>

									<td class="product-name">
										<?php
											if ( ! $product_permalink ) {
												echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
											} else {
												echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
											}

											// Meta data
											/*compatibility 3.3.0*/
											if(function_exists('wc_get_formatted_cart_item_data')) {
												echo wc_get_formatted_cart_item_data( $cart_item );
											} else {
												echo WC()->cart->get_item_data( $cart_item );
											}

											// Backorder notification
											if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
												echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'dfd' ) . '</p>';
											}
										?>
									</td>

									<td class="product-price">
										<?php
											echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
										?>
									</td>

									<td class="product-quantity">
										<?php
											if ( $_product->is_sold_individually() ) {
												$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
											} else {
												$product_quantity = woocommerce_quantity_input( array(
													'input_name'  => "cart[{$cart_item_key}][qty]",
													'input_value' => $cart_item['quantity'],
													'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
													'min_value'   => '0',
												), $_product, false );
											}

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
										?>
									</td>

									<td class="product-subtotal">
										<?php
											echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
										?>
									</td>
									
									<td class="product-remove">
										<?php
											echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
												'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
												esc_url( $remove_link ),
												__( 'Remove this item', 'dfd' ),
												esc_attr( $product_id ),
												esc_attr( $_product->get_sku() )
											), $cart_item_key );
										?>
									</td>
								</tr>
								<?php
							}
						}

						do_action( 'woocommerce_cart_contents' );
						?>

						<?php do_action( 'woocommerce_after_cart_contents' ); ?>
					</tbody>
				</table>

				<?php do_action( 'woocommerce_after_cart_table' ); ?>
				
				<div class="coupon">
					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="box-name"><?php _e( 'Coupon discount', 'dfd' ); ?>:</div>
						<?php /* <div class="subtitle"><?php _e( 'Sign up to get updates & discounts!', 'dfd' ); ?>:</div> */ ?>
						<div class="dfd-coupon-wrap">
							<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'dfd' ); ?>" />
							<span><input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'dfd' ); ?>" /></span>
						</div>

						<?php do_action('woocommerce_cart_coupon'); ?>
					<?php } ?>
					<div class="dfd-submit-wrap">
						<input type="submit" class="button button-grey" name="update_cart" value="<?php _e( 'Update Cart', 'dfd' ); ?>" />
					</div>

				</div>
				
			</div>

			<div class=" five columns cart-collaterals">
				<div class="cover">
					<?php // woocommerce_cart_totals(); ?>
					
					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart' ); ?>

					<?php do_action( 'woocommerce_cart_collaterals' ); ?>

					<div class="clear"></div>

					<?php /*<input type="submit" class="checkout-button button alt wc-forward" name="proceed" value="<?php _e( 'Proceed to Checkout', 'dfd' ); ?>" />*/ ?>

					<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

				</div>
			</div>

		</div>
	</form>

	<div class="container-shortcodes">
		<div class="block-title"><?php esc_html_e('Top rated products','dfd'); ?></div>
		<?php echo do_shortcode('[top_rated_products per_page="4" columns="4"]') ?>
	</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
