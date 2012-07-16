<?php
/**
 * @package Preserve_Code_Formatting
 * @author Scott Reilly
 * @version 3.2
 */
/*
Plugin Name: Preserve Code Formatting
Version: 3.2
Plugin URI: http://coffee2code.com/wp-plugins/preserve-code-formatting/
Author: Scott Reilly
Author URI: http://coffee2code.com
Text Domain: preserve-code-formatting
Domain Path: /lang/
Description: Preserve formatting of code for display by preventing its modification by WordPress and other plugins while retaining original whitespace and characters.

NOTE: Use of the visual text editor will pose problems as it can mangle your intent in terms of <code> tags.  I do not
offer any support for those who have the visual editor active.

Compatible with WordPress 3.1+, 3.2+, 3.3+.

=>> Read the accompanying readme.txt file for instructions and documentation.
=>> Also, visit the plugin's homepage for additional information and updates.
=>> Or visit: http://wordpress.org/extend/plugins/preserve-code-formatting/
*/

/*
Copyright (c) 2004-2012 by Scott Reilly (aka coffee2code)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

if ( ! class_exists( 'c2c_PreserveCodeFormatting' ) ) :

require_once( 'c2c-plugin.php' );

class c2c_PreserveCodeFormatting extends C2C_Plugin_032 {
	public static $instance;

	private $chunk_split_token = '{[&*&]}';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->c2c_PreserveCodeFormatting();
	}

	public function c2c_PreserveCodeFormatting() {
		// Be a singleton
		if ( ! is_null( self::$instance ) )
			return;

		parent::__construct( '3.2', 'preserve-code-formatting', 'c2c', __FILE__, array() );
		register_activation_hook( __FILE__, array( __CLASS__, 'activation' ) );
		self::$instance = $this;
	}

	/**
	 * Handles activation tasks, such as registering the uninstall hook.
	 *
	 * @since 3.1
	 *
	 * @return void
	 */
	public function activation() {
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
	}

	/**
	 * Handles uninstallation tasks, such as deleting plugin options.
	 *
	 * This can be overridden.
	 *
	 * @since 3.1
	 *
	 * @return void
	 */
	public function uninstall() {
		delete_option( 'c2c_preserve_code_formatting' );
	}

	/**
	 * Initializes the plugin's configuration and localizable text variables.
	 *
	 * @return void
	 */
	public function load_config() {
		$this->name      = __( 'Preserve Code Formatting', $this->textdomain );
		$this->menu_name = __( 'Code Formatting', $this->textdomain );

		$this->config = array(
			// input can be 'checkbox', 'text', 'hidden', or 'none'
			'preserve_tags' => array( 'input' => 'text', 'default' => array( 'code', 'pre' ), 'datatype' => 'array',
					'label' => __( 'Tags that will have their contents preserved', $this->textdomain ),
					'help' => __( 'Space and/or comma-separated list of HTML tag names.', $this->textdomain ) ),
			'preserve_in_comments' => array( 'input' => 'checkbox', 'default' => true,
					'label' => __( 'Preserve code in comments?', $this->textdomain ),
					'help' => __( 'Preserve code posted by visitors in comments?', $this->textdomain ) ),
			'wrap_multiline_code_in_pre' => array( 'input' => 'checkbox', 'default' => true,
					'label' => __( 'Wrap multiline code in <code>&lt;pre></code> tag?', $this->textdomain ),
					'help' => __( '&lt;pre> helps to preserve whitespace', $this->textdomain ) ),
			'use_nbsp_for_spaces' => array( 'input' => 'checkbox', 'default' => true,
					'label' => __( 'Use <code>&amp;nbsp;</code> for spaces?', $this->textdomain ),
					'help' => __( 'Not necessary if you are wrapping code in <code>&lt;pre></code> or you use CSS to define whitespace:pre; for code tags.', $this->textdomain ) ),
			'nl2br' => array( 'input' => 'checkbox', 'default' => false,
					'label' => __( 'Convert newlines to <code>&lt;br/></code>?', $this->textdomain ),
					'help' => __( 'Depending on your CSS styling, you may need this.  Otherwise, code may appear double-spaced.', $this->textdomain ) )
		);
	}

	/**
	 * Override the plugin framework's register_filters() to register actions and filters.
	 *
	 * @return void
	 */
	public function register_filters() {
		$options = $this->get_options();

		add_filter( 'the_content',             array( &$this, 'preserve_preprocess' ), 2 );
		add_filter( 'the_content',             array( &$this, 'preserve_postprocess_and_preserve'), 100 );
		add_filter( 'content_save_pre',        array( &$this, 'preserve_preprocess' ), 2 );
		add_filter( 'content_save_pre',        array( &$this, 'preserve_postprocess' ), 100 );

		add_filter( 'the_excerpt',             array( &$this, 'preserve_preprocess' ), 2 );
		add_filter( 'the_excerpt',             array( &$this, 'preserve_postprocess_and_preserve' ), 100 );
		add_filter( 'excerpt_save_pre',        array( &$this, 'preserve_preprocess' ), 2 );
		add_filter( 'excerpt_save_pre',        array( &$this, 'preserve_postprocess' ), 100 );

		if ( $options['preserve_in_comments'] ) {
			add_filter( 'comment_text',        array( &$this, 'preserve_preprocess' ), 2 );
			add_filter( 'comment_text',        array( &$this, 'preserve_postprocess_and_preserve' ), 100 );
			add_filter( 'pre_comment_content', array( &$this, 'preserve_preprocess' ), 2 );
			add_filter( 'pre_comment_content', array( &$this, 'preserve_postprocess' ), 100 );
		}
	}

	/**
	 * Outputs the text above the setting form
	 *
	 * @return void (Text will be echoed.)
	 */
	public function options_page_description() {
		$options = $this->get_options();
		parent::options_page_description( __( 'Preserve Code Formatting Settings', $this->textdomain ) );
		echo '<p>' . __( 'Preserve formatting for text within &lt;code> and &lt;pre> tags (other tags can be defined as well). Helps to preserve code indentation, multiple spaces, prevents WP\'s fancification of text (ie. ensures quotes don\'t become curly, etc).', $this->textdomain ) . '</p>';
		echo '<p>' . __( 'NOTE: Use of the visual text editor will pose problems as it can mangle your intent in terms of &lt;code> tags. I do not offer any support for those who have the visual editor active.', $this->textdomain ) . '</p>';
	}

	/**
	 * Preps code.
	 *
	 * @param string $text Text to prep
	 * @return string The prepped text
	 */
	public function prep_code( $text ) {
		$options = $this->get_options();
		$text = preg_replace( "/(\r\n|\n|\r)/", "\n", $text );
		$text = preg_replace( "/\n\n+/", "\n\n", $text );
		$text = str_replace( array( "&#36&;", "&#39&;" ), array( "$", "'" ), $text );
		$text = htmlspecialchars( $text, ENT_QUOTES );
		$text = str_replace( "\t", '  ', $text );
		if ( $options['use_nbsp_for_spaces'] )
			$text = str_replace( '  ', '&nbsp;&nbsp;', $text );
		if ( $options['nl2br'] )
			$text = nl2br( $text );
		return $text;
	}

	/**
	 * Preserves the code formatting for text.
	 *
	 * @param string $text Text with code formatting to preserve
	 * @return string The text with code formatting preserved
	 */
	public function preserve_code_formatting( $text ) {
		$text = str_replace( array( '$', "'" ), array( '&#36&;', '&#39&;' ), $text );
		$text = $this->prep_code( $text );
		$text = str_replace( array( '&#36&;', '&#39&;', '&lt; ?php' ), array( '$', "'", '&lt;?php' ), $text );
		return $text;
	}

	/**
	 * Preprocessor for code formatting preservation process.
	 *
	 * @param string $content Text with code formatting to preserve
	 * @return string The text with code formatting preprocessed
	 */
	public function preserve_preprocess( $content ) {
		$options = $this->get_options();
		$preserve_tags = $options['preserve_tags'];
		$result = '';
		foreach ( $preserve_tags as $tag ) {
			if ( ! empty( $result ) ) {
				$content = $result;
				$result = '';
			}
			$codes = preg_split( "/(<{$tag}[^>]*>.*<\\/{$tag}>)/Us", $content, -1, PREG_SPLIT_DELIM_CAPTURE );
			foreach ( $codes as $code ) {
				if ( preg_match( "/^<({$tag}[^>]*)>(.*)<\\/{$tag}>/Us", $code, $match ) ) {
					$code = "[[{$match[1]}]]";
					$code .= base64_encode( addslashes( chunk_split( serialize( $match[2]), 76, $this->chunk_split_token ) ) );
					$code .= "[[/{$tag}]]";
				}
				$result .= $code;
			}
		}
		return $result;
	}

	/**
	 * Post-processor for code formatting preservation process.
	 *
	 * @param string $content Text with code formatting that had been preprocessed
	 * @param bool $preserve (optional) Preserve?
	 * @return string The text with code formatting post-processed
	 */
	public function preserve_postprocess( $content, $preserve = false ) {
		$options = $this->get_options();
		$preserve_tags = $options['preserve_tags'];
		$wrap_multiline_code_in_pre = $options['wrap_multiline_code_in_pre'];
		$result = '';
		foreach ( $preserve_tags as $tag ) {
			if ( ! empty( $result ) ) {
				$content = $result;
				$result = '';
			}
			$codes = preg_split( "/(\\[\\[{$tag}[^\\]]*\\]\\].*\\[\\[\\/{$tag}\\]\\])/Us", $content, -1, PREG_SPLIT_DELIM_CAPTURE );
			foreach ( $codes as $code ) {
				if ( preg_match( "/\\[\\[({$tag}[^\\]]*)\\]\\](.*)\\[\\[\\/{$tag}\\]\\]/Us", $code, $match ) ) {
					$data = unserialize( str_replace( $this->chunk_split_token, '', stripslashes( base64_decode( $match[2] ) ) ) );
					if ( $preserve )
						$data = $this->preserve_code_formatting( $data );
					$code = "<{$match[1]}>$data</$tag>";
					if ( $preserve && $wrap_multiline_code_in_pre && preg_match( "/\n/", $data ) )
						$code = '<pre>' . $code . '</pre>';
				}
				$result .= $code;
			}
		}
		return $result;
	}

	/**
	 * Post-processor for code formatting preservation process that defaults to true for preserving.
	 *
	 * @param string $content Text with code formatting to post-process and preserve
	 * @return string The text with code formatting post-processed and preserved
	 */
	public function preserve_postprocess_and_preserve( $content ) {
		return $this->preserve_postprocess( $content, true );
	}

} // end c2c_PreserveCodeFormatting

// To access plugin object instance use: c2c_PreserveCodeFormatting::$instance
new c2c_PreserveCodeFormatting();

endif; // end if !class_exists()

?>