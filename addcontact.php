<?php 
include('./includes/header.php');
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

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $data = $database->getReference("contacts/$id");
    $contact = $data->getValue();
    $name = $contact['name'];
    $email = $contact['email'];
    $mobile = $contact['mobile'];
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $data = [
        'by' => @$uid,
        'name' => $name,
        'email' => $email,
        'mobile' => $mobile,
    ];
    if(isset($_GET['id'])){
        $uid = $_GET['id'];
        $updates = [
            "contacts/$uid" => $data
        ];
        $database->getReference()
        ->update($updates);
    }else{
    $uid = $database->getReference('contacts')->push()->getKey();
    $updates = [
        "contacts/$uid" => $data
    ];
    
    $database->getReference()
    ->update($updates);
    }

    header('location: index.php');
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="d-flex justify-content-between">Add Contact
                        <a href="./index.php" class="btn btn-danger">Back</a>
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form class="form" method="POST">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Your Name..." value=<?php echo @$name ?>>
                                </div>
                                <div class="form-group">
                                    <label for="name">Email:</label>
                                    <input type="text" class="form-control" name="email" placeholder="Enter Your Email..." value=<?php echo @$email ?>>
                                </div>
                                <div class="form-group">
                                    <label for="name">Mobile:</label>
                                    <input type="text" class="form-control" name="mobile" placeholder="Enter Your Mobile no. ..." value=<?php echo @$mobile ?>>
                                </div>
                                <?php if(isset($_GET['id'])){ ?>
                                    <input class="btn btn-success" type="submit" value="Update" name="submit">
                                <?php  }else{ ?>
                                    <input class="btn btn-primary" type="submit" value="Save" name="submit">
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('./includes/footer.php') ?>