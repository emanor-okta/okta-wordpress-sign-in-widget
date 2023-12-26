<?php include plugin_dir_path(__FILE__).'/../includes/widget.php'; ?>

<script>
<?php include plugin_dir_path(__FILE__).'/../includes/okta.js.php'; ?>

authClient.tokenManager.get('idToken').then(function(idToken){
    if(idToken) {
      debugLog('idToken found, logging out of Okta');
      authClient.signOut({
          idToken: idToken,
          postLogoutRedirectUri: '<?php echo home_url() ?>'
      });
    } else {
      debugLog('No idToken Returned, Skipping Okta Logout');
      window.location = '<?php echo home_url() ?>';
    }
});
</script>
