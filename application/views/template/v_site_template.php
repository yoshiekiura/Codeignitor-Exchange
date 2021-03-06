<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/fav.ico'); ?>">
    <title>Welcome</title>
    <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/anychart-ui.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('css/style.css'); ?>" rel="stylesheet">
    <?php if (isset($head_css)) echo $head_css; ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<div class="wrapper">
    <header>
        <div class="main_menu">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="cls_logo"><a href="<?php echo base_url(); ?>"><img
                                        src="<?php echo base_url(); ?>images/logo.png" class="img-responsive" alt="">
                            </a></div>
                    </div>
                    <?php if (!$this->session->user_id > 0) { ?>
                        <div class="col-md-8 col-sm-7 col-xs-8 col-lg-9">
                            <ul class="list-inline list-unstyled cls_top_login">
                                <li><a href="<?php echo base_url(); ?>login"> Login </a></li>
                                <li><a href="<?php echo base_url(); ?>register" class="active"> Register </a></li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-8 col-sm-7  col-xs-8 col-lg-9">
                            <ul class="list-inline list-unstyled cls_top_login">
                                <li><a href="/markets/EUR-NLG"> Markets </a></li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>
</div>
<div class="cls_content">
    <?php if (isset($content)) echo $content; ?>
</div>
<footer>
    <div class="cls_footer_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class="cls_footer_text">
                        <div class="cls_footer_logo"><a href="#"><img src="<?php echo base_url(); ?>images/logo.png"
                                                                      alt="" height="30px"> </a></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua.
                        </p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="cls_footer_con">
                        <div></div>
                        <h3></h3>
                        <p></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="cls_footer_con">
                        <div><img src="<?php echo base_url('images/footer_icon2.png'); ?>" alt=""></div>
                        <h3>Connect with us</h3>
                        <ul class="cls_socil_links">
                            <li><a href="http://www.facebook/guldentrader" target="_blank"><i
                                            class="fa fa-facebook"></i> facebook</a></li>
                            <li><a href="http://www.twitter.com/guldentrader" target="_blank"><i
                                            class="fa fa-twitter"></i> twitter</a></li>
                            <!--  <li><a href=""><i class="fa fa-linkedin"></i> Youtube</a></li>
                            <li><a href="" target="_blank"><i class="fa fa-google-plus"></i> googleplus</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="cls_footer_con">
                        <div><img src="<?php echo base_url('images/footer_icon2.png'); ?>" alt=""></div>
                        <h3> Contact </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="cls_ffoter_bot">
            Copyright <?php echo date('Y') ?>, All Rights Reserved
        </div>
</footer>
<script type="text/javascript">var base_url = '<?php echo base_url(); ?>'; </script>
<script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('js/anystock.min.js'); ?>"></script>
<script src="<?php echo base_url('js/chart_nlg.js'); ?>"></script>
<script src="<?php echo base_url('js/jquery.nicescroll.min.js'); ?>"></script>
<script src="<?php echo base_url('js/jquery.validate.min.js'); ?>"></script>
<?php if (isset($head_js)) echo $head_js; ?>
</body>
</html>