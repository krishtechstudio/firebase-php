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
                    <h2 class="d-flex justify-content-between">Login
                    <a href="register.php" class="btn btn-primary">Register</a>
                    </h2>
                </div>
                <div class="card-body">
                    <?php if(isset($_SESSION['reg_message'])){
                        echo '<div class="alert alert-success">'.$_SESSION["reg_message"].'</div>';
                        unset($_SESSION['reg_message']);
                    } ?>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form class="form" method="POST">
                            <?php if(isset($_POST['submit'])){
                                $email = $_POST['email'];
                                $password = $_POST['password'];
                                try{
                                $signInResult = $auth->signInWithEmailAndPassword($email, $password);
                                $idToken = $signInResult->idToken();
                                try{
                                    $verifiedToken = $auth->verifyIdToken($idToken);
                                    $uid = $verifiedToken->claims()->get('sub');
                                    $_SESSION['token'] = $idToken;
                                    $_SESSION['uid'] = $uid;
                                    header('location: index.php');
                                }catch(Exception $e){
                                    echo '<div class="alert alert-danger">Invalid Auth Token !!</div>';
                                }
                                }catch(Exception $e){
                                   echo '<div class="alert alert-danger">Invalid Email and Password !!</div>';
                                }
                            } 
                            ?>
                                <div class="form-group">
                                    <label for="name">Email:</label>
                                    <input type="text" class="form-control" name="email" placeholder="Enter Your Email...">
                                </div>
                                <div class="form-group">
                                    <label for="name">Password:</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter Your Mobile no. ...">
                                </div>
                                    <input class="btn btn-primary" type="submit" value="Login" name="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('./includes/footer.php') ?>