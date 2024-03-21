<?php
/**
 * @package Hello_Dolly_Complainer
 * @version 1.0.0
 */
/*
Plugin Name: Hello Dolly Complainer
Plugin URI: http://wordpress.org/plugins/hello-dolly-complainer/
Description: Let's complain a bit.
Author: Wojtek Naruniec
Version: 1.0.0
Author URI: http://naruniec.me/
*/

function hello_dolly_get_complain() {
	/** These are the lyrics to Hello Dolly */
	$lyrics = "Really?
Why?
I don't think so!
Not that pretty!
Again an again
Blah blah blah";

	// Here we split it into lines.
	$lyrics = explode( "\n", $lyrics );

	// And then randomly choose a line.
	return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later.
function hello_dolly_complainer() {
	$chosen = hello_dolly_get_complain();
	$lang   = '';
	if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
		$lang = ' lang="en"';
	}

	printf(
		'<p id="dollyc"><span dir="ltr"%s>%s</span></p>',
		$lang,
		$chosen
	);
}

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'admin_notices', 'hello_dolly_complainer' );

// We need some CSS to position the paragraph.
function dolly_complainer_css() {
	echo "
	<style type='text/css'>
	#dollyc {
		float: right;
		padding: 5px 10px;
		margin: 0;
		font-size: 9px;
                color: red;
		line-height: 1.6666;
	}
	.rtl #dollyc {
		float: left;
	}
	.block-editor-page #dollyc {
		display: none;
	}
	@media screen and (max-width: 782px) {
		#dollyc,
		.rtl #dollyc {
			float: none;
			padding-left: 0;
			padding-right: 0;
		}
	}
	</style>
	";
}

add_action( 'admin_head', 'dolly_complainer_css' );
