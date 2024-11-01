/**
 * Load media uploader on pages with our custom metabox
 */
jQuery(document).ready(function ($) {

	'use strict';

	// Instantiates the variable that holds the media library frame.
	var metaImageFrame;

	// Runs when the media button is clicked.
	$('body').click(function (e) {

		// Get the btn
		var btn = e.target;

		// Check if it's the upload button
		if (!btn || !$(btn).attr('data-woofv-uploader-target')) return;

		// Get the field target
		var field = $(btn).data('woofv-uploader-target');

		// Prevents the default action from occuring.
		e.preventDefault();

		// Sets up the media library frame
		console.log(field);
		if ('#woofv_video_embed_url' == field){
			metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
				title: meta_image.title,
				button: {
					text: meta_image.button
				},
				library: {
					type: 'video/MP4'
				},
				multiple: false
			});
		}else{
			metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
				title: meta_image.title,
				button: {
					text: meta_image.button
				},
			});
		}


		// Runs when an image is selected.
		metaImageFrame.on('select', function () {

			// Grabs the attachment selection and creates a JSON representation of the model.
			var media_attachment = metaImageFrame.state().get('selection').first().toJSON();

			// Sends the attachment URL to our custom image input field.
			$(field).val(media_attachment.url);

		});

		// Opens the media library frame.
		metaImageFrame.open();

	});

	// Stop video when thumbnail is clicked
	$('body').on('click', '.flex-control-thumbs li img', function (event) {
		$('video').get(0).pause()
	});

	// Stop video when thumbnail is clicked
	$('body').on('click', 'a.woocommerce-product-gallery__trigger', function (event) {
		// $('video').get(0).pause()
		// console.log(ProductGallery);
		// console.log(pswp);
		// console.log(PhotoSwipe);
	});

	// Stop video when thumbnail is clicked
	// $('body').on('wc-product-gallery-after-init', function (a,b) {
	// 	console.log('Grrrh!!!');

	// });

	$(this).on('click', 'a.woocommerce-product-gallery__trigger', function (event) {
		
		console.log('aaa');

		// Add PSWP element
		$('.pswp__container').append('<div class="pswp__item woofv" style="display: block;"><div class="pswp__zoom-wrap" style=""><div class="pswp__img pswp__img--placeholder pswp__img--placeholder--blank" style="width: 310px; height: 310px; display: none;"></div></div></div>');

		// Duplicate
		let $originalVideo = '';
		let $clonedVideo = '';

		$originalVideo = $('.woofv_video .wp-video');
		// $clonedVideo = $originalVideo.clone();
		
		// Replace current video with a clone
		// $('.woocommerce-product-gallery__image.woofv_video').append($clonedVideo);

		// Output original video in preview
		$('.woofv .pswp__zoom-wrap').html($originalVideo);
		// $().css('')
		// $('.woofv_video .wp-video').html('');

		// $('body').append($video);

		// Add MEJS video to PSWP element
		// $('.pswp__zoom-wrap.woofv').append($('.mejs-container'));
		// $('.pswp__zoom-wrap.woofv .mejs-container').css('margin', '0 auto');
	});

	$('body').on('click', '.pswp__container', function () {
		if (!$('.pswp').hasClass('pswp--open')){

			let $originalVideo = '';
			let $video = '';

			$originalVideo = $('.pswp__item.woofv .pswp__zoom-wrap');
			$video = $originalVideo.find('.wp-video');
			console.log($video);
			$('.woofv_video').html($video);
			$('.pswp__item.woofv').remove();
		}
	});



});