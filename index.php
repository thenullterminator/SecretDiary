
<?php

$error='';$success='';

if($_POST)
{
    
    if($_POST['signinup']==1 && !$_POST['email'])
    $error=$error."> Please Enter email address<br>";
    
    if ($_POST['signinup']==1 && (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) && $_POST['email']) 
    $error=$error. "> Invalid Email Address<br>";   
    
    if(!$_POST['username'])
    $error=$error."> Username is required<br>";
    
    if(!$_POST['password'])
    $error=$error."> Password is required<br>";
    
    if($error!="")
    $error='<div class="alert alert-danger" role="alert"><b>'.$error.'</b></div>';
    else
    {    
        
        $link =mysqli_connect("localhost","","","");
        if(mysqli_connect_error())
        {
            $error='<div class="alert alert-danger" role="alert"><b>Failed To connect to Database. Try again later :(</b><p></p> </div>';
        }
        else
        {
            //Database Connected...
        
            if($_POST['signinup']==1)//Sign UP...........
            {
                
                $query="SELECT id FROM secretdiary WHERE username='".mysqli_real_escape_string($link,$_POST['username'])."'";
                $result=mysqli_query($link,$query);
                
                if(mysqli_num_rows($result)>0)
                {
                    $error='<div class="alert alert-danger" role="alert"><b>Username already taken. Try another one!</b><p></p> </div>';
                }
                else
                {
                   
                    //unique username exists..
                    $query="INSERT INTO secretdiary (username,email,password) VALUES ('".mysqli_real_escape_string($link,$_POST['username'])."','".mysqli_real_escape_string($link,$_POST['email'])."','".md5($_POST['password'])."')";
                    
                    if(mysqli_query($link,$query))
                    {
                        
                        $to = $_POST['email'];
                        $subject = "Confirmation Email";
                        
                        $message = "This mail is to verify your account being opened :)";
                        
                        // Always set content-type when sending HTML email
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        
                        // More headers
                        $headers .= 'From: Dhairya Patel' . "\r\n";
                        
                        if($_POST['loggedin']=='on')
                        {
                            setcookie("username",$_POST['username'],time()+0.5*60*60);
                        }
                        else
                        {
                            session_start();
                            $_SESSION['username']=$_POST['username'];
                        }
                        
                        if (mail($to,$subject,$message))
                        {
                            $success='<div class="alert alert-success" role="alert"><p><b> Your Account is being successfully created!<br> A confirmation email is sent to you :)<br><a href="Diarypage.php">Go to your Diary</a></b></p></div>';
                        }
                       else
                        {
                            $error='<div class="alert alert-success" role="alert"><b>Your Account is being successfully created!<br><a href="Diarypage.php">Go to your Diary</a></b><p></p> </div>';
                        }
                        
                        
                        
                    }
                    else
                    {
                        $error='<div class="alert alert-danger" role="alert"><b>Some Internal error Occured! :(</b><p></p> </div>';
                    }
                }
                
            }
            else //sign in page..
            {
                $query="SELECT id FROM secretdiary WHERE username='".mysqli_real_escape_string($link,$_POST['username'])."'";
                $result=mysqli_query($link,$query);
                
                if(mysqli_num_rows($result)>0)
                {
                    $query="SELECT password FROM secretdiary WHERE username='".mysqli_real_escape_string($link,$_POST['username'])."'";
                    $result=mysqli_query($link,$query);
                    $row=mysqli_fetch_array($result);
            
                    if($row['password']==md5($_POST['password']))
                    {
                        if($_POST['loggedin']=='on')
                        {
                            setcookie("username",$_POST['username'],time()+0.5*60*60);
                        }
                        else
                        {
                        session_start();
                        $_SESSION['username']=$_POST['username'];
                        }
                        header("Location:Diarypage.php");
                    }
                    else
                    {
                        $error='<div class="alert alert-danger" role="alert"><b>Incorrect Password! :(</b><p></p> </div>';
                    }
                }
                else
                {
                    $error='<div class="alert alert-danger" role="alert"><b>Account Not found Sign Up Instead!</b><p></p> </div>';
                }
            }
        
        }
        
    }
    
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
        /* For Entire Background as Image */
    html
    {
        background: linear-gradient(rgba(255,255,255,0.3), rgba(255,255,255,0.5)), url("IMG1.jpg") no-repeat center center fixed;
        -webkit-background-size:cover; 
        -moz-background-size:cover;
        -o-background-size:cover;
        background-size: cover;

        margin:0;
            padding:0;
    }

    body{
        background:none;
        overflow-y:hidden;
        margin:0;
            padding:0;
    }
    h1{
        backdrop-filter: blur(10px);
    }

   form{
        width:29%;
        margin:7.5vw auto;
        /* background-color:red; */
        font-family: 'Montserrat', sans-serif;
        text-align:center;
        
    }

    #title
    {
        width:100%;
        font-weight:bold;
        margin:0 auto !important;
        font-size:2vw;
       }
    #subtitle
    {
        width:100%;
        font-weight:bold;
        margin:0 auto !important;
        font-size:1vw;
    }

    #subcontent
    {
        width:100%;
        font-weight:bold;
        margin:0 auto !important;
        font-size:1vw;
    }
    #stayli
    {
        margin:0 auto;
        width:34%;
    }
    .form-control{
        height:2.5vw;
        font-size:1.1vw !important;
    }
    .text-muted {
    color: black !important;
    font-size:0.7vw;
}
    #signincontent
    {
      width:44%;
    }

    a
    {
      color:#0069D9 !important;
      font-weight:bold;
      cursor: pointer;
    }

    </style>

  </head>
  <body>

        <form method="post">

                <div id="title">Secret Diary</div>
                <p></p>
                <div id="subtitle">Store your thoughts permanently and securely.</div>
                <p></p><br>
                <div id="subcontent"> <span id="signupcontent">Interested ? Sign up Now!</span> <span id="signincontent" style="display:none;" >Log In using your username and password</span></div>
                <br>
                
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Username">
                   <p></p><br>
                  <!-- <label for="exampleInputEmail1">Email address</label> -->
                  <div class="form-group" id="signupdetails">
                  <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Your email">
                  <small id="emailHelp" class="form-text text-muted" style="text-align:left;color:black">We'll never share your email with anyone else.</small>
                  </div>
                  <input type="hidden" id="signinup" name="signinup" value="0">

                <div class="form-group">
                  <!-- <label for="exampleInputPassword1">Password</label> -->
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
                <p></p><br>
                <div class="form-check" id="stayli">
                  <input type="checkbox" class="form-check-input" id="loggedin" name="loggedin">
                  <label class="form-check-label" for="exampleCheck1"> Stay Logged in.</label>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" id="submit"><span id="signupbutton">Sign Up!</span> <span id="signinbutton" style="display:none;" >Log In!</span></button>
                <p></p>
                <a id="login" >Log In.</a><a id="signup" style="display:none;" >Sign Up.</a>
                <p></p>

                <div id="error"><?php echo $error;?><?php echo $success;?> <?php echo $_SESSION['username'];?></div>
                
         </form>

        
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/JavaScript">
         
         
              
      $("#login").click(function()
      {
          $("#signupdetails").toggle();
          $("#login").toggle();
          $("#signup").toggle();
          $("#signupcontent").toggle();
          $("#signincontent").toggle();
          $("#signinbutton").toggle();
          $("#signupbutton").toggle();
      });
        
      $("#signup").click(function()
      {
          $("#signupdetails").toggle();
          $("#login").toggle();
          $("#signup").toggle();
          $("#signupcontent").toggle();
          $("#signincontent").toggle();
          $("#signinbutton").toggle();
          $("#signupbutton").toggle();
      });
      
      $("form").submit(function () {
        
       var error="";
       if($("#username").val()=='')
       {
         error+="> Please Enter a Username.<br>";
       }
       if($("#email").val()=='' && $("#email").is(":visible"))
       {
         error+="> Please Enter a E-Mail Address.<br>";
       }
       if($("#password").val()=='')
       {
         error+="> Please Enter password.<br>";
       }
       
       if($("#email").is(":visible"))
       {
           document.getElementById('signinup').value = 1 ;
       }
       
       if(error=='')
       return true;
       else
       {
         $("#error").html('<div class="alert alert-danger" role="alert" style="text-align:left"><strong>'+error+'</strong></div>');
         return false;
       }
      });
      
      </script>
  </body>
</html>
