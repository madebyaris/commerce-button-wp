<?php
/**
 * Plugin Name: Commerce Button Indonesia
 * Plugin URI: https://github.com/madebyaris/commerce-button-wp
 * Description: This plugin is only for learning purpose, this plugin will make your post have url to your product, you can still use it. if you like to develop and need my support. contact me
 * Author: M Aris Setiawan
 * Version: 0.1
 * Author URI: https://github.com/madebyaris/
 *
 * @package commerce-button
 */

namespace commerceBtn;

// If accessed directly, abort!
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'You shall not pass!' );
}

/**
 * Pergunakan Class untuk mempermudah pembuatan aplikasi dan juga agar mudah untuk melakukan scaling up untuk kedepanya (optional ya).
 */
class CommerceButton {

	/**
	 * Disini untuk meletakan variabel konstan.
	 *
	 * @var $list_commerce array Definisikan tombol apa saja yang ingin dibuat.
	 */
	protected $list_commerce = [ 'bukalapak', 'tokopedia' ];

	/**
	 * Construct saat pemanggilan class
	 */
	public function __construct() {

		// Jika ada action/tindakan itu hanya untuk didalam admin, maka kita perlu melakukan hal ini, agar efisiensi memory usage tidak banyak.
		if ( is_admin() ) {
			add_action( 'add_meta_boxes', array( $this, 'register_metabox_button' ) ); // Ini adalah cara untuk memanggil didalam class.
		}
	}

	/**
	 * Daftarkan (register) metabox dulu
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_meta_box/
	 */
	public function register_metabox_button() {
		add_meta_box(
			'commerce-button', // Id
			'produk', // Title
			array( $this, 'cb_commerce_button' ), // Callback (memanggil function)
			'post', // Screen dimana kita memunculkan box ini (post,page, etc)
			'normal', // Context dimana kita akan menempatkan tombol ini (normal,side,advanced)
			'high', // Priority apakah ingin dimunculkan paling atas, atau paling bawah.
			array( $this, 'absint' ) // callback_args coba buka link diatas (dia tidak akan melakukan apa-apa jika dikasih ini).
		);
	}

	/**
	 * Disini Kita akan memunculkan input field & ini adalah callback.
	 *
	 * @param object $post get data from $post edit.
	 */
	public function cb_commerce_button( $post ) {
		$prefix = 'cmbtn_'; // Gunakan prefix agar terhindar dari custom meta yang memiliki nama yang sama (menghindari bentrok dengan plugin yang memiliki nama field yang sama).
		$values = get_post_custom( $post->id ); // Ambil custom meta dengan ini.

		// We'll use this nonce field later on when saving. coba cari tahu apa itu wp_nonce.
		wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );

		foreach ( $this->list_commerce as $commerce ) :
			$meta_name = $prefix . $commerce;
			$val = isset( $values[ $meta_name ] ) ? esc_attr( $values[ $meta_name ] ) : ''; // Inline if, dan pengecekan apakah field meta kosong atau tidak!
			?>
			<p>
				<label for="<?php echo esc_attr( $meta_name ); ?>">alamat produk di <?php echo esc_html( $commerce ); ?> </label><br>
				<input type="text" name="<?php echo esc_attr( $meta_name ); ?>" id="<?php echo esc_attr( $meta_name ); ?>">
			<p>
			<?php
		endforeach;// Gunakan endif, endwhile, endforeach. bila kodingan di dalam dirasa panjang, sehingga akan memudahkan kita untuk melihat isi dari pengulangan ini.
	}

}

new CommerceButton();
