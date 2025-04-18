<? include("database.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Guardian PI</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0; 
        }

        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Login Box Styling */
        .login-box {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-box h1 {
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Submit Button Styling */
        .submit-btn {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            font-size: 1.2rem;
            text-align: center;
            color: #FF0000; /* red color for errors */
        }
    </style>
</head>
<body>

    <div class="login-box">
        <h1>Guardian PI</h1>

        <!-- Login Form -->
        <form action="#" method="POST">
            <!-- Username Field -->
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <!-- Password Field -->
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Register</button>
        </form>
    </div>

</body>
</html>

<?
    $notice = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($username)) {
            $notice = "Please enter a username";
        } elseif(empty($password)) {
            $notice = "Please enter a password";
        } else {
            $hash = password_hash($password, PASSWORD_ARGON2I);
            $sql = "INSERT INTO users (user, password)
                    VALUES ('$username', '$hash')";
            
            try {
                mysqli_query($conn, $sql);
                $notice = "You are now registered!";
            } catch(mysqli_sql_exception){
                $notice = "That username is taken";
            }
            
        }
        
    }
    
    // Tries to display message below the form lol
    if ($notice != "") {
        echo "<div class='message'>$notice</div>";
    }
    
    mysqli_close($conn);
?>
