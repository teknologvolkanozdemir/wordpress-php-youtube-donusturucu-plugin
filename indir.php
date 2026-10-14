<?php
/**
 * Plugin Name: İndir
 * Description: YouTube videolarını gömer ve yetkili olduğunuz MP3/MP4 dosyalarına indirme bağlantıları ekler.
 * Version: 1.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: indir
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders a YouTube embed and optional links to authorized media files.
 *
 * @param array $attributes Shortcode attributes.
 * @return string
 */
function indir_youtube_media_shortcode( $attributes ) {
	$attributes = shortcode_atts(
		array(
			'youtube' => '',
			'mp3'     => '',
			'mp4'     => '',
		),
		$attributes,
		'indir'
	);

	$output   = '';
	$video_id = indir_youtube_media_video_id( $attributes['youtube'] );

	if ( $video_id ) {
		$output .= '<div class="indir-youtube-video"><iframe src="https://www.youtube-nocookie.com/embed/' . esc_attr( $video_id ) . '" title="' . esc_attr__( 'YouTube video player', 'indir' ) . '" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div>';
	}

	$links = array(
		'mp3' => __( 'MP3 dosyasını indir', 'indir' ),
		'mp4' => __( 'MP4 dosyasını indir', 'indir' ),
	);

	foreach ( $links as $format => $label ) {
		$url = esc_url( trim( $attributes[ $format ] ), array( 'http', 'https' ) );
		if ( $url ) {
			$output .= '<p class="indir-download indir-download-' . esc_attr( $format ) . '"><a href="' . $url . '" download>' . esc_html( $label ) . '</a></p>';
		}
	}

	return $output;
}
add_shortcode( 'indir', 'indir_youtube_media_shortcode' );

/**
 * Extracts a video ID only from recognized YouTube URL formats.
 *
 * @param string $url Submitted YouTube URL.
 * @return string|false
 */
function indir_youtube_media_video_id( $url ) {
	$parts = wp_parse_url( trim( $url ) );

	if ( empty( $parts['host'] ) ) {
		return false;
	}

	$host = strtolower( $parts['host'] );
	$path = isset( $parts['path'] ) ? trim( $parts['path'], '/' ) : '';
	$id   = '';

	if ( 'youtu.be' === $host ) {
		$id = strtok( $path, '/' );
	} elseif ( in_array( $host, array( 'youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtube-nocookie.com', 'www.youtube-nocookie.com' ), true ) ) {
		if ( isset( $parts['query'] ) ) {
			parse_str( $parts['query'], $query );
			if ( isset( $query['v'] ) ) {
				$id = $query['v'];
			}
		}

		if ( ! $id && preg_match( '#^(?:embed|shorts|live)/([^/]+)$#', $path, $matches ) ) {
			$id = $matches[1];
		}
	}

	return is_string( $id ) && preg_match( '/^[A-Za-z0-9_-]{11}$/', $id ) ? $id : false;
}
