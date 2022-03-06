<?php include('./includes/header.php');
include('./dbcon.php');

if(isset($_SESSION['token'])){
    try{
        $verifiedToken = $auth->verifyIdToken($_SESSION['token']);
        $uid = $_SESSION['uid'];
        $user = $auth->getUser($uid);
    }catch(Exception $e){
        header('location: login.php');
    }
}else{
    header('location: login.php');
}
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="d-flex justify-content-between">Welcome, <?php echo @$user->displayName ?>
                    <div class="btn-list">
                    <?php 
                        if($_SESSION['uid'] == "73FjELH40qPrWFC17xYqdwGfM4N2"){
                            ?>
                            <a href="./notify.php" class="btn btn-warning">Send Notification</a>
                            <?php
                        }
                        ?>
                        <a href="./addcontact.php" class="btn btn-primary">Add Contact</a>
</div>
                    </h2>
                </div>
                <div class="card-body">
                    <?php
                    $data = $database->getReference('contacts');
                    $contacts = $data->getValue();
                    if($contacts == ""){
                        echo '<div class="alert alert-danger">no contacts found</div>';
                    }else{
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile no.</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $data = $database->getReference('contacts');
                            $contacts = $data->getValue();
                            $i = 1;
                            foreach($contacts as $key => $row){
                                if($_SESSION['uid'] == $row['by']){
                                echo '<tr>';
                                echo '<td>'.$i.'</td>';
                                echo '<td>'.$row['name'].'</td>';
                                echo '<td>'.$row['email'].'</td>';
                                echo '<td>+91 '.$row['mobile'].'</td>';
                                echo '<td><a href="addcontact.php?id='.$key.'" class="btn btn-success">edit</a></td>';
                                echo '<td><a href="delete.php?id='.$key.'" class="btn btn-danger">delete</a></td>';
                                echo '</tr>';
                                $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('./includes/footer.php') ?>