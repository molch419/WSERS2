<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    if (
        isset($_POST["Username"]) &&
        isset($_POST["Password"])
    ) {
        include_once("credentials.php");
        // Create connection
        $connection = mysqli_connect($servername, $username, $password, $database);
        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $userFromMyDatabase = $connection->prepare("SELECT * FROM ppl WHERE UserName=?");
        $userFromMyDatabase->bind_param("s", $_POST["Username"]);
        $userFromMyDatabase->execute();
        $result = $userFromMyDatabase->get_result();
        if ($result->num_rows === 1) {
            print "Your password is being verified <BR>";
            $row = $result->fetch_assoc();

            if (password_verify($_POST["Password"], $row["Password"]))
            //if ($row["Password"]===$hashedPassword)
            {
                print "You have been successfully logged-in";
            } else {
                print "Wrong password ! Please type your password correctly";
            }
        } else {
            print "The username you typed has not been found in our database !! Please register first !";
    ?> <a href="signup.php">Go to the signup page</a>
            <a href="login.php">Try again</a>
        <?php
        }
    } else {
        ?>
        <form action="login.php" method="post">
            Username: <input type="text" name="Username" required><br>
            Password: <input type="password" name="Password" required><br>
            <input type="submit" name="Login" value="Login">
        </form>
    <?php
    }
    ?>
</body>

</html>