<form id="ryans-login-form" action="login" method="post"><h3 class="h1"><!?php _e('Login', 'ryans-login-form') ?></h3>

    <label for="username"><?php _e('Email', 'ryans-login-form'); ?></label> <input id="ryans-login-username" name="username" type="text" >
    <label for="password"><?php _e('Password', 'ryans-login-form'); ?></label> <input id="ryans-login-password" name="password" type="password" >

    <button name="submit" type="submit" value="<?php _e('Login', 'ryans-login-form') ?>"><?php _e('Login', 'ryans-login-form') ?></button>
		
    <a class="register small" href="<?php bloginfo('url'); ?>/register/"><?php _e('Signup', 'ryans-login-form'); ?></a><br>
    <a class="lost small" href="<?php echo wp_lostpassword_url(); ?>"><?php _e('Lost your password?' , 'ryans-login-form'); ?></a>
		
    <?php wp_nonce_field( 'ryans-login-nonce', 'nonce' ); ?>
		
</form>