<?php
include 'inc\DB.php';
if(isset($_POST['LOGIN'])){
    $c = new DB();
    $sql="select * from users where LOGIN ='".$_POST['LOGIN']."'  and PASSWORD ='".$_POST['PASSWORD']."' ";
    $reponse = $c->cnx->query($sql);
    $infos = $reponse->fetch();
    if ($infos >0){
        session_start();
        $_SESSION['login']=$infos['LOGIN'];
        header('location:home.php');
    }else{
        header('location:index.php?error');
    }

}
?>
<html>
<head>
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link href="css/index.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <img src="images/logo.jpg" id="icon" alt="User Icon"  />
        </div>

        <!-- Login Form -->
        <form action="#" method="post">
            <input type="text" id="login" class="fadeIn second" name="LOGIN" placeholder="Nom d'utilisateur">
            <input type="text" id="password" class="fadeIn third" name="PASSWORD" placeholder="Mot de passe">
            <input type="submit" class="fadeIn fourth" value="Connection">
        </form>

        <!-- Remind Passowrd -->
        <div id="formFooter">
            <a class="underlineHover" href="#"><?php if(isset($_GET['error'])){ echo "Verifiez votre login et mot de passe";}?></a>
        </div>

    </div>
</div>
</body>
</html>
