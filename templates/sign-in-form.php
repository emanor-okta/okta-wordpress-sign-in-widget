<?php include plugin_dir_path(__FILE__).'/../includes/widget.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

<script>
  <?php include plugin_dir_path(__FILE__).'/../includes/okta.js.php'; ?>

</script>


<style type="text/css">
    body {
        font-family: montserrat,Arial,Helvetica,sans-serif;        
    }

    #wordpress-login{
        text-align: center;
    }

    #wordpress-login a{
        font-size:10px;
        color: #999;
        text-decoration:none;
    }

    #error {
        max-width: 500px;
        margin: 20px auto;
        padding: 20px;
        border: 1px #d93934 solid;
        border-radius: 6px;
    }
    #error h2 {
        color: #d93934;
    }
</style>

<?php if(isset($_GET['error'])): ?>
<div id="error">
    <h2>Error: <?php echo htmlspecialchars($_GET['error']) ?></h2>
    <p><?php echo htmlspecialchars($_GET['error_description']) ?></p>
</div>
<?php endif ?>

<div id="primary" class="content-area">
  <div id="okta-login-container">
    <div class="d-grid gap-2 col-6 mx-auto">
      <?php if(get_option('okta-allow-wordpress-login')): ?>
        <a href="<?php echo wp_login_url(); ?>?wordpress_login=true" class="btn btn-primary btn-lg" type="button">Login with WordPress</a>
      <?php endif ?>
      <a id="okta-login" class="btn btn-secondary btn-lg" type="button">Login with Okta</a>
    </div>
  </div>
  <div id="logged-in">
    <!--h1>User Logged In Splash Screen</h1-->
  </div>
</div>

<script>
  if (authClient.isLoginRedirect()) {
    debugLog('sign-in-form.php.isLoginRedirect()');
    document.getElementById("okta-login-container").style.display = "none";
    document.getElementById("logged-in").style.display = "block";
    handleRedirect();
  } else {
    <?php if(get_option('okta-auto-redirect-login')): ?>
      loginWithRedirect();
    <?php endif ?>
    document.getElementById("okta-login-container").style.display = "block";
    document.getElementById("logged-in").style.display = "none";
  }

  oktaLogin = document.getElementById('okta-login');
  oktaLogin.onclick = loginWithRedirect;
</script>
