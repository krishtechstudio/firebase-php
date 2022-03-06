<?php
include('./includes/header.php');
include('./dbcon.php');

function sendMessage($title, $message) {
    $content      = array(
        "en" => $message
    );
    $heading = array(
        "en" => $title
    );
    $fields = array(
        'app_id' => "29189ce1-b56e-4b57-b4e4-d209e623d5c2",
        'included_segments' => array(
            'Subscribed Users'
        ),
        'contents' => $content,
        'headings' => $heading
    );
    
    $fields = json_encode($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic MTI4Zjg5ZDktYjVjOC00Nzc3LTliZTctNzQxN2NiYTAwMWJj'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response);
}


?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h2 class="d-flex justify-content-between">Send Notification
                    <a href="index.php" class="btn btn-danger">Back</a>
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form class="form" method="POST">
                            <?php if(isset($_POST['submit'])){
                                $title = $_POST['title'];
                                $message = $_POST['message'];
                                $response = sendMessage($title, $message);
                                if($response){
                                    echo '<div class="alert alert-success">Notification Sent To <b>'.$response->recipients.'</b> Users</div>';
                                }
                            } 
                            ?>
                                <div class="form-group">
                                    <label for="name">Title:</label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter Title...">
                                </div>
                                <div class="form-group">
                                    <label for="name">Message:</label>
                                    <textarea rows="4" class="form-control" name="message" placeholder="Enter Message..."></textarea>
                                </div>
                                    <input class="btn btn-primary" type="submit" value="Send" name="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('./includes/footer.php') ?>