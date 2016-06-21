<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $title ?></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<script type="text/javascript" src="application/view/templates/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="application/view/templates/jquery.slidertron-1.3.js"></script>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" />
<link href="<?= base_url() ?>template/css/default.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?= base_url() ?>template/css/fonts.css" rel="stylesheet" type="text/css" media="all" />

<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body>
<div class="wrapper">
<div id="login">
    <h1>Login</h1>
     <?php if($msg){ ?>
             <div class="validation_pass">
                <p><?= $msg ?></p>
             </div>
    <?php } if(validation_errors()){
        echo '<div class="validation">All fields are Compleasary!</div>';   } 
    echo form_open('account/login') ?>
    <div class="login_content">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="login" value="login" class="button">
       
        
    </div>
    </form>
</div>
</div>
</body>
</html>    
