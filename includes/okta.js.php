    var authClient = new OktaAuth({
        issuer: '<?php echo get_option('okta-issuer-url') ?>',
        redirectUri: '<?php echo wp_login_url() ?>',
        clientId: '<?php echo get_option('okta-widget-client-id') ?>',
        scopes: '<?php echo apply_filters( 'okta_widget_token_scope', 'openid email') ?>'.split(' ')
    });

    async function handleRedirect() {
      debugLog('In handleRedirect()');
      let r = await authClient.token.parseFromUrl();
      debugLog('setTokens()', r.tokens);
      authClient.tokenManager.setTokens(r.tokens);
      window.location = window.location.href = '<?php echo wp_login_url() ?>' + '?log_in_from_id_token=' + r.tokens.idToken.idToken;
    }

    function loginWithRedirect() {
      authClient.signInWithRedirect()
      .then(function(tokens) {
          //console.log('signInWithRedirect(): ')
      }).catch(function(error) {
        debugLog('signInWithRedirect() Error:', error);
      });
    }

    function debugLog(errStr, error) {
      <?php if(get_option('okta-debug-log')): ?>
        console.log(errStr);
        if (error) {
          console.log(error);
        }
      <?php endif ?>
    }
