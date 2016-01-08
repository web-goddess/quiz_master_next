<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* This function shows the about page. It also shows the changelog information.
*
* @return void
* @since 4.4.0
*/

function mlw_generate_about_page()
{
	global $mlwQuizMasterNext;
	$mlw_quiz_version = $mlwQuizMasterNext->version;
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_script( 'jquery-ui-button' );
	wp_enqueue_script( 'jquery-effects-blind' );
	wp_enqueue_script( 'jquery-effects-explode' );
	wp_enqueue_style( 'qmn_admin_style', plugins_url( '../css/qmn_admin.css' , __FILE__ ) );
	wp_enqueue_script('qmn_admin_js', plugins_url( '../js/admin.js' , __FILE__ ));
	?>
	<style>
		div.mlw_qmn_icon_wrap
		{
			background: <?php echo 'url("'.plugins_url( 'images/quiz_icon.png' , __FILE__ ).'")'; ?> no-repeat;
		}
	</style>
	<div class="wrap about-wrap">
		<h1><?php _e('Welcome To Quiz And Survey Master (Formerly Quiz Master Next)', 'quiz-master-next'); ?></h1>
		<div class="about-text"><?php _e('Thank you for updating!', 'quiz-master-next'); ?></div>
		<div class="mlw_qmn_icon_wrap"><?php echo $mlw_quiz_version; ?></div>
		<h2 class="nav-tab-wrapper">
			<a href="javascript:qmn_select_tab(1, 'mlw_quiz_what_new');" id="mlw_qmn_tab_1" class="nav-tab nav-tab-active">
				<?php _e("What's New!", 'quiz-master-next'); ?></a>
			<a href="javascript:qmn_select_tab(2, 'mlw_quiz_changelog');" id="mlw_qmn_tab_2" class="nav-tab">
				<?php _e('Changelog', 'quiz-master-next'); ?></a>
			<a href="javascript:qmn_select_tab(3, 'qmn_contributors');" id="mlw_qmn_tab_3" class="nav-tab">
				<?php _e('People Who Make QMN Possible', 'quiz-master-next'); ?></a>
		</h2>
		<div id="mlw_quiz_what_new" class="qmn_tab">
			<h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">New Dynamic Form Submission</h2>
			<p style="text-align: center;">Rather than making a user wait for an entire page submission, now the plugin dynamically calculates the results and displays the results page.</p>
			<br />
			<h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">Specify From Email Address And Reply-To</h2>
			<p style="text-align: center;">After several requests, I have finally added the option to specify a from email address for sending emails. I also added the option to add a reply-to email to the admin emails using the user email.</p>
			<br />
			<hr />
			<h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">For Developers:</h2>
			<br />
      <h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">JavaScript Re-write</h2>
			<p style="text-align: center;">I re-wrote all the JavaScript files and combined them into one file.</p>
      <br />
      <h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">Renamed files/functions</h2>
			<p style="text-align: center;">I renamed many files and functions to align with WordPress standards. None of these were externally used and will not affect your customizations/code.</p>
      <br />
			<h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">We Are On GitHub Now</h2>
			<p style="text-align: center;">We love github and use it for all of our plugins! Be sure to <a href="https://github.com/fpcorso/quiz_master_next/">make suggestions or contribute</a> to our Quiz And Survey Master repository.</p>
			<br />
		</div>
		<div id="mlw_quiz_changelog" class="qmn_tab" style="display: none;">
			<h2>Changelog</h2>
			<h3><?php echo $mlw_quiz_version; ?> (December 15, 2015)</h3>
			<ul class="changelog">
				<!--
				Examples:
				<li class="add"><div class="two">Add</div>Some feature was added</li>
				<li class="fixed"><div class="two">Fixed</div>Fixed some bug</li>
				-->
				<li class="fixed"><div class="two">Fixed</div>* Fixes undefined results notice displayed on admin results for some users</li>
				<li class="fixed"><div class="two">Fixed</div>* Fixes bug that was causing the disable radio buttons option to not work in all browsers</li>
				<li class="fixed"><div class="two">Fixed</div>* Minor design changes</li>
			</ul>
		</div>
		<div id="qmn_contributors" class="qmn_tab" style="display:none;">
			<h2>GitHub Contributors</h2>
			<?php
			$contributors = get_transient( 'qmn_contributors' );
			if ( false === $contributors ) {
				$response = wp_remote_get( 'https://api.github.com/repos/fpcorso/quiz_master_next/contributors', array( 'sslverify' => false ) );
				if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
					$contributors = array();
				} else {
					$contributors = json_decode( wp_remote_retrieve_body( $response ) );
				}
			}
			if ( is_array( $contributors ) & ! empty( $contributors ) ) {
				set_transient( 'qmn_contributors', $contributors, 3600 );
				$contributor_list = '<ul class="wp-people-group">';
				foreach ( $contributors as $contributor ) {
					$contributor_list .= '<li class="wp-person">';
					$contributor_list .= sprintf( '<a href="%s" title="%s">',
						esc_url( 'https://github.com/' . $contributor->login ),
						esc_html( sprintf( __( 'View %s', 'edd' ), $contributor->login ) )
					);
					$contributor_list .= sprintf( '<img src="%s" width="64" height="64" class="gravatar" alt="%s" />', esc_url( $contributor->avatar_url ), esc_html( $contributor->login ) );
					$contributor_list .= '</a>';
					$contributor_list .= sprintf( '<a class="web" href="%s" target="_blank">%s</a>', esc_url( 'https://github.com/' . $contributor->login ), esc_html( $contributor->login ) );
					$contributor_list .= '</a>';
					$contributor_list .= '</li>';
				}
				$contributor_list .= '</ul>';
				echo $contributor_list;
			}
			?>
			<a href="https://github.com/fpcorso/quiz_master_next" target="_blank" class="button-primary">View GitHub Repo</a>
		</div>
	</div>
<?php
}
?>