<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cendratama - Login Client</title>

    <style>.bg-video {
  background-size: cover;
  background: no-repeat center;
  user-select: none;
  pointer-events: none;
  /* frameborder:0;  */
  height: 100%;"
  overflow: hidden}

.zoom {
  padding: 2px;
  transition: transform .2s; /* Animation */
  width: 35px;
  height: 35px;
  margin: 0 auto;
}

.zoom:hover {
  transform: scale(1.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}
</style>
    <link rel="stylesheet" href="<?=base_url('assets/template/dist')?>/assets/css/main/app.css">
    <link rel="stylesheet" href="<?=base_url('assets/template/dist')?>/assets/css/pages/auth.css">
    <link rel="icon" type="image/x-icon" href="<?=base_url('assets/logo/favicon-32x32.png')?>">


    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=<?=$_ENV['recaptchaSiteKey']?>"></script>
</head>

<body>
    <div id="auth">
        
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
<!--             <div class="auth-logo">
                <a href="index.html"><img src="<?=base_url('assets/template/dist')?>/assets/images/logo/logo.svg" alt="Logo"></a>
            </div> -->
            <h1 class="auth-title">Log in.</h1>
            <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

            <form method="post">
            <input class="input100" type="hidden" name="token_generate" id="token_generate">
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" class="form-control form-control-xl" name="email" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" class="form-control form-control-xl" name="password" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <!-- <div class="form-check form-check-lg d-flex align-items-end"> -->
                    <div class="text-center mt-5 text-lg fs-4">
                    <?php if (isset($_SESSION['login_error'])){
                        ?>
                        </br>
                        <div class="alert alert-danger" role="alert">
                        <ul>
                        <?php foreach ($_SESSION['login_error'] as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                        
                        </ul>
                    </div>
                    <?php }?>
                    <div class="text-center mt-5 text-lg fs-4">

                     <?php if (isset($_SESSION['buttonVerify'])){
                        echo $_SESSION['buttonVerify'];
                     }?>
                     <?php if (isset($_SESSION['message'])){
                        echo '<div class="alert alert-info" role="alert">';
                        echo $_SESSION['message'];
                        echo '</div>';
                     }?>
      
                 </div>
                <span class='text-gray-600'>Log in with:</span>
                <a href="<?=$login_link?>"><img class="zoom" src="<?=base_url('assets')?>/logo/google.png"></a>

            <!-- </div> -->
                    </label>
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" name="submit" value = "login">Log in</button>
                <div class="text-center mt-5 text-lg fs-4">or</div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" name="submit" value = "toReg">Register</button>
            </form>

        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">
        <!-- <iframe class="bg-video"  src="https://www.youtube.com/embed/79qjW_1E7s8?autoplay=1&mute=1&controls=0&loop=1&playlist=79qjW_1E7s8" height="100%" width="100%" ></iframe> -->
            <!-- <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/79qjW_1E7s8?controls=0&autoplay=1&mute=1&&loop=1" height="100% title="West Papua" frameborder="0" allow="loop; accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
        </div>
    </div>
</div>

    </div>
</body>

</html>
<script>
             grecaptcha.ready(function() {
                 grecaptcha.execute("<?=$_ENV['recaptchaSiteKey']?>").then(function(token) {
                         // Add your logic to submit to your backend server here.
                         var response = document.getElementById('token_generate');
                         response.value = token;
                 });
             });

 </script>