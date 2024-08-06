<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
    $system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
    foreach($system as $k => $v){
        $_SESSION['system'][$k] = $v;
    }
}
ob_end_flush();
?>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php echo $_SESSION['system']['name'] ?></title>

    <?php include('./header.php'); ?>
    <?php 
    if(isset($_SESSION['login_id']))
    header("location:index.php?page=home");

    ?>

<style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa; /* Changed background color */
            background-image: url('http://surl.li/rmgtz'); /* Replace 'glass_bg.jpg' with your image path */
            background-size: cover;
            background-position: center;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            z-index: -1;
        }

        #login-container {
            display: flex;
            max-width: 800px;
            width: 100%;
        }

        .logo-container {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .login-form-container {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 3rem;
            color: black ; /* Changed logo color */
            margin-bottom: 20px;
        }

        .illustration {
            width: 100%;
            max-width: 400px;
            height: auto;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div id="login-container">
        <div class="logo-container">
            <div class="logo">Property Rental Management System</div>
        </div>
        <div class="login-form-container">
            <form id="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                </div>
                <button class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</body>

<script>
    $('#login-form').submit(function(e){
        e.preventDefault()
        $('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
        if($(this).find('.alert-danger').length > 0 )
            $(this).find('.alert-danger').remove();
        $.ajax({
            url:'ajax.php?action=login',
            method:'POST',
            data:$(this).serialize(),
            error:err=>{
                console.log(err)
                $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
            },
            success:function(resp){
                if(resp == 1){
                    location.href ='index.php?page=home';
                }else{
                    $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
                    $('#login-form button[type="button"]').removeAttr('disabled').html('Login');
                }
            }
        })
    })
</script>    
</html>
