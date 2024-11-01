<?php
	// Variables
	global $post;
	$saved = get_post_meta( $post->ID, '_woofv_video_embed', true );
	$video = isset($saved['url']) ? $saved['url'] : '';
	$thumbnail = isset($saved['thumbnail']) ? $saved['thumbnail'] : '';
	$poster = isset($saved['poster']) ? $saved['poster'] : '';
	$autoplay = isset($saved['autoplay']) ? $saved['autoplay'] : '0';
	wp_nonce_field( 'woofv_video_box', 'woofv_video_box_nonce' );
?>

<fieldset>

	<p>
		<label for="woofv_video_embed[url]"><?php _e( 'Video URL', 'woofv' ); ?></label><br/>
		<input type="url" class="" name="woofv_video_embed[url]" id="woofv_video_embed_url" value="<?php echo esc_attr( $video ); ?>">
		<button type="button" class="button" id="events_video_upload_btn" data-woofv-uploader-target="#woofv_video_embed_url"><?php _e( 'Upload', 'myplugin' ); ?></button>
	</p>

	<p>
		<label for="woofv_video_embed[thumbnail]"><?php _e( 'Gallery Thumbnail', 'woofv' ); ?></label><br/>
		<input type="url" class="" name="woofv_video_embed[thumbnail]" id="woofv_video_embed_thumbnail" value="<?php echo esc_attr( $thumbnail ); ?>">
		<button type="button" class="button" id="events_video_upload_btn" data-woofv-uploader-target="#woofv_video_embed_thumbnail"><?php _e( 'Upload', 'myplugin' ); ?></button>
	</p>

	<p>
		<label for="woofv_video_embed[poster]"><?php _e( 'Video poster', 'woofv' ); ?></label><br/>
		<input type="url" class="" name="woofv_video_embed[poster]" id="woofv_video_embed_poster" value="<?php echo esc_attr( $poster ); ?>">
		<button type="button" class="button" id="events_video_upload_btn" data-woofv-uploader-target="#woofv_video_embed_poster"><?php _e( 'Upload', 'myplugin' ); ?></button>
	</p>

	<p>
		<label for="woofv_video_embed[autoplay]"><?php _e( 'Autoplay', 'woofv' ); ?></label><br/>
		<select name="woofv_video_embed[autoplay]" id="woofv_video_embed_autoplay">
			<option value="0" <?php selected($autoplay, '0') ?>><?php _e( 'No', 'myplugin' ); ?></option>
			<option value="1" <?php selected($autoplay, '1') ?>><?php _e( 'Yes', 'myplugin' ); ?></option>
		</select>
	</p>

</fieldset>

<?php

// Security field
wp_nonce_field( 'myplugin_form_metabox_nonce', 'myplugin_form_metabox_process' );
