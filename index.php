<?php
/**
 * Kenapa kita membuat index.php kosongan ?
 * Agar tidak ada yang bisa melihat isi path dari directory.
 *
 * @link https://codex.wordpress.org/Writing_a_Plugin
 * @link https://pippinsplugins.com/series/writing-your-first-wordpress-plugins-basic-to-advanced/  langsung yang ini aja belajarnya
 * @package commerce-button
 */

// If accessed directly, abort!
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'You shall not pass!' );
}
