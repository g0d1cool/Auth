<?
session_start();
?>
<!doctype html>
<html lang="ru">

    <head>
        
        <meta charset="utf-8" />
        <title>Добро пожаловать!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body class="auth-body-bg">
        <div class="home-btn d-none d-sm-block">
            <a href="handlers/exit.php"><i class="mdi mdi-exit-to-app h1 text-white"></i></a>
        </div>
        <div>
            <div class="container-fluid p-0">
                <div class="row no-gutters">
                    <div class="col-lg-4">
                        <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                            <div class="w-100">
                                <div class="row justify-content-center">
                                    <div class="col-lg-9">
                                        <div>
                                            <div class="text-center">
    
                                                <h4 class="font-size-18 mt-4">Привет <? echo $_SESSION['name']; ?></h4>
                                                <p class="text-muted">съешь ещё этих мягких французских булок, да выпей чаю<br>съешь ещё этих мягких французских булок, да выпей чаю</p>
                                            </div>

                                            <div class="p-2 mt-5">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="authentication-bg" style="background-image: url(assets/images/comingsoon-bg.jpg);">
                            <div class="bg-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script type="text/javascript">
            $(window).resize(function () { 
                var width = $('body').innerWidth();
                if (width < 1000){
                    $('.mdi-exit-to-app').removeClass('text-white');
                    $('.mdi-exit-to-app').addClass('text-black');
                }
                else{
                    $('.mdi-exit-to-app').removeClass('text-black');
                    $('.mdi-exit-to-app').addClass('text-white');
                }
            });
        </script>
    </body>
</html>
