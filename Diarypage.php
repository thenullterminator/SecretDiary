<?php
    
    session_start();
    $msg='';
    $content='';
    if($_SESSION['username']||$_COOKIE['username'])
    {
        $link =mysqli_connect("localhost","dhairyaj_djp2803","Sonu2803#","dhairyaj_MyfirstDB");
        $query="SELECT content FROM secretdiary WHERE username='".mysqli_real_escape_string($link,$_SESSION['username'])."'";
        $result=mysqli_query($link,$query);
        $content=mysqli_fetch_array($result)['content'];
        if($_SESSION['username'])
        $msg=$_SESSION['username'];
        else
        $msg=$_COOKIE['username'];
        
        if($_POST['logout']=='run')
        {
            if($_POST["diary"])
            {
                $query="UPDATE  secretdiary SET content='".mysqli_real_escape_string($link,$_POST['diary'])."' WHERE username='".mysqli_real_escape_string($link,$_SESSION['username'])."'";
                $result=mysqli_query($link,$query);
            }
            if($_SESSION['username'])
            {
            $_SESSION = array();
            session_destroy();
            }
            else
            {
                setcookie("username",'',time()-600);
            }
            
            header("Location:index.php");
        }
    }
    else
    {
        header("Location:index.php");
    }


?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="shortcut icon" href="/diary.png" type="image/png">
    <title>Secret Diary</title>


    <style type="text/css">

        @import url('https://fonts.googleapis.com/css?family=Montserrat');

        html
        {
            background: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url("IMG1.jpg") no-repeat center center fixed;
            -webkit-background-size:cover; 
            -moz-background-size:cover;
            -o-background-size:cover;
            background-size: cover;    
             
        }
    
        body
        {
            background:none;
            font-family: 'Montserrat', sans-serif;
            margin:3vw;
            
        }
        h1
        {
            font-weight:bold;
            float:left;
            font-size:2.2vw;
        }
        button
        {
            float:right;
            font-size:1.6vw !important; 
        }
        textarea{
            margin-top:1vw;
            width:100%;
        }
       
    </style>



  </head>
  <body>
    <form method="post">
    <div id="title">

        <h1>Welcome <?php echo $msg; ?>!</h1>
        <button type="submit" id="logout" name="logout" value="run" class="btn btn-outline-dark">Log Out!</button>

    </div>
    <div style="clear: both"></div>
    
    <textarea name="diary" rows="31" placeholder="This Diary is yours ! Share your feelings with it and lighten your heart :)"><?php echo $content;?></textarea>
    </form>

    <script type="text/javascript">
    
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>