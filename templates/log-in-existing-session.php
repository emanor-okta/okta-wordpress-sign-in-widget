<?php include plugin_dir_path(__FILE__).'/../includes/widget.php'; ?>

<script>
<?php include plugin_dir_path(__FILE__).'/../includes/okta.js.php'; ?>


  authClient.session.exists()
  .then(function(exists) {
    if (authClient.isLoginRedirect()) {
      // user redirected back from /authorize complete login
      debugLog('isLoginRedirect()');
      handleRedirect();
    } else if(exists) {
      // user has Okta session, attempt to acquire tokens
      debugLog('Session exits, calling getWithoutPrompt()');
      authClient.token.getWithoutPrompt({
        responseType: ['id_token'],
      })
      .then(function(tokens){
        authClient.tokenManager.setTokens(tokens.tokens);
        window.location.href = '<?php echo wp_login_url() ?>' + '?log_in_from_id_token=' + tokens.tokens.idToken.idToken;
      })
      .catch( (error) => {
        // user had Okta session, but failed authorize call. Often happens if user is required to re-auth session
        debugLog('getWithoutPrompt() Error: ', error);
        loginWithRedirect();
      });
    } else {
      // no Okta seesion detected (3rd party cookies), only authorize if configured to auto authorize
      debugLog('Okta session not detected');
      <?php if(get_option('okta-auto-redirect-login')): ?>
        loginWithRedirect();
      <?php endif ?>
    }
  })
  .catch( (error)=> {
    // should not see, only authorize if configured to auto authorize
    debugLog('Error checking for session: ', error);
    <?php if(get_option('okta-auto-redirect-login')): ?>
      loginWithRedirect();
    <?php endif ?>
  });

</script>
