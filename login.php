<?php 
session_start();
include "functions.php";

//cek cookie
if(isset($_COOKIE['id']) && isset($_COOKIE['key'])){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //ambil username dari database
    $result = mysqli_query($conn,"SELECT username from user where id=$id;");
    $data = mysqli_fetch_assoc($result);
    if($key === hash('sha256',$data['username'])){
        $_SESSION['login']= true;
    }
}

if(isset($_SESSION['login'])){
    header('Location: index.php');
    exit;
}


if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn,"SELECT * from user where username = '$username'");

    
    //cek username
    //mysqli num rows untuk mengecek apakaha ada baris yang sesuai, jika benar =1 dan jika tdk benar =0
    if(mysqli_num_rows($result) === 1){

        $row = mysqli_fetch_assoc($result);
  
        //password verify adalah untuk memvalidasi password hasil enkripsi dari password hash
        
        if(password_verify($password,$row['password'])){

            //set session
            $_SESSION['login'] = true;
            
            //cek remember me
            if(isset($_POST['remember'])){
                //buat cookie
                setcookie('id', $row['id'],time()+60);
                setcookie('key', hash('sha256',$row['username'],time()+60));
            }

            header("Location: index.php");
            exit; //agar eksekusi program berhenti di sini
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            color: #2d3748;
            margin-bottom: 2rem;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        button:hover {
            transform: translateY(-1px);
            opacity: 0.9;
        }

        .additional-links {
            margin-top: 1.5rem;
            text-align: center;
        }

        .additional-links a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s ease;
        }

        .additional-links a:hover {
            color: #764ba2;
        }

        @media (max-width: 480px) {
            .login-container {
                width: 90%;
                padding: 1.5rem;
            }
        }

        .error-message {
            background: #ffe3e6;
            color: #ff4444;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #ffcccc;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            animation: slideDown 0.3s ease-out;
            font-size: 0.9rem;
        }

        .error-message svg {
            flex-shrink: 0;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tambahkan ini di media query untuk responsive */
        @media (max-width: 480px) {
            .error-message {
                padding: 0.8rem;
                font-size: 0.85rem;
            }
        }

        .remember-me {
        margin: 1rem 0;
    }

    .checkbox-container {
        display: block;
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        user-select: none;
        color: #4a5568;
        font-size: 0.9rem;
    }

    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .checkbox-container:hover input ~ .checkmark {
        border-color: #667eea;
    }

    .checkbox-container input:checked ~ .checkmark {
        background-color: #667eea;
        border-color: #667eea;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .checkbox-container input:checked ~ .checkmark:after {
        display: block;
    }

    @media (max-width: 480px) {
        .checkbox-container {
            font-size: 0.85rem;
        }
        
        .checkmark {
            height: 22px;
            width: 22px;
        }

        .checkmark:after {
            left: 7px;
            top: 4px;
        }
    }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Welcome Back</h1>
        <!-- Tambahkan di bagian atas form login -->
        <?php if(isset($error)): ?>
        <div class="error-message">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            <span><?php echo "Username atau Password yang anda masukkan salah" ?></span>
        </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Enter your username">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password">
            </div>

            <div class="form-group remember-me">
                <label class="checkbox-container">
                    <input type="checkbox" name="remember" id="remember">
                    <span class="checkmark"></span>
                    Remember Me
                </label>
            </div>
            
            <button type="submit" name="login">Login</button>
            
            <div class="additional-links">
                <a href="#">Forgot Password?</a>
                <p style="margin-top: 1rem; color: #718096;">Don't have an account? <a href="#">Sign up</a></p>
            </div>
        </form>
    </div>
</body>
</html>