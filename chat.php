<?php

    if(!isset($_SESSION)) 
    { 
        session_start();
    }
require 'bin/functions.php';
include('header.php');
?>
<html>
<head>
    <title>ABCD</title>
    <link href="css/chat.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./css/responsive_style.css">
</head>
<body>
        
    <div class="contentContainer">
    
    <h1 class="mainTitle">Welcome to Project ABCD</h1>
    <h2 class="subTitle">A Bite of Culture in Dresses</h2>
    <h2 class="selectTitle">Type in question to start chatting.</h2><br>
    
    <?php require('chatbot.php'); ?>
    
   

    </div>
</body>

</html>