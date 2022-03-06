<?php 
include('./includes/header.php');
include('./dbcon.php');

if(isset($_SESSION['token'])){
    try{
        $verifiedToken = $auth->verifyIdToken($_SESSION['token']);
        $uid = $_SESSION['uid'];
        $user = $auth->getUser($uid);
        header('location: index.php');
    }catch(Exception $e){
        
    }
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="d-flex justify-content-between">Register
                        <a href="login.php" class="btn btn-primary">Login</a>
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form class="form" method="POST">
                                <?php if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userProperties = [
        'email' => $email,
        'password' => $password,
        'displayName' => $name,
    ];
    try {
    $createdUser = $auth->createUser($userProperties);
    if($createdUser){
        $_SESSION['reg_message'] = "Registration Successful";
        header('location: login.php');
    }
    }catch(Exception $error){
                                        echo '<div class="alert alert-danger">User already exists !!</div>';
                                    }
                                }
                                ?>
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Your Name...">
                                </div>
                                <div class="form-group">
                                    <label for="name">Email:</label>
                                    <input type="text" class="form-control" name="email" placeholder="Enter Your Email...">
                                </div>
                                <div class="form-group">
                                    <label for="name">Password:</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Your Mobile no. ...">
                                </div>
                                    <input class="btn btn-primary" type="submit" value="Resgiter" name="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('./includes/footer.php') ?>