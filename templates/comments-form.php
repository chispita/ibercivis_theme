<?php if ('open' == $post->comment_status) : ?>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p><?php _e('You must be', THEMEDOMAIN); ?><a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e('logged in', THEMEDOMAIN); ?></a> <?php _e('to post a comment', THEMEDOMAIN);?>.</p><br/>
	<?php else : ?>

					<!-- Start of form --> 
					<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="comment_form"> 
					<fieldset> 

			
			
						<h5 class="cufon"><?php _e( 'Leave A Reply', THEMEDOMAIN ); ?></h5>
						
						<?php if ( is_user_logged_in() ) : ?>

					<?php _e('Logged in as', THEMEDOMAIN); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out &raquo;', THEMEDOMAIN); ?></a><br/><br/>

			<?php else : ?>
						<br/>
						<p> 
							<input class="round m input" title="<?php _e( 'Name', THEMEDOMAIN ); ?>*" name="author" type="text" id="author" value="" tabindex="1" style="width:50%" /> 
						</p> 
						<p> 
							<input class="round m input" title="<?php _e( 'Email', THEMEDOMAIN ); ?>*" name="email" type="text" id="email" value="" tabindex="2" style="width:50%" /> 
						</p> 
						<p>
                        <!-- 
							<input class="round m input" title="<?php _e( 'Website', THEMEDOMAIN ); ?>" name="url" type="text" id="url" value="" tabindex="3" style="width:50%" /> 
						</p>
                        --> 

			<?php endif; ?>
						
						<p>  
							<textarea name="comment" title="<?php _e( 'Message', THEMEDOMAIN ); ?>*" cols="10" rows="3" id="comment" tabindex="4" style="width:95%"></textarea> 
						</p> 
						<br /> 
						<p> 
							<input name="submit" type="submit" id="submit" value="<?php _e( 'Submit', THEMEDOMAIN ); ?>" tabindex="5" />&nbsp;
							<?php cancel_comment_reply_link('Cancel Reply'); ?> 
						</p> 
						<?php comment_id_fields(); ?> 

					</fieldset> 

						<?php do_action('comment_form', $post->ID); ?>


					</form> 
					<!-- End of form --> 
			

	<?php endif; // If registration required and not logged in ?>

<?php endif; // if comment is open ?>
