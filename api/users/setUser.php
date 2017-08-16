<?php

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $sqlError;

    if( !isset($request->user) ) {
        echo json_encode(array( 'success' => false, 'error' => 'No user ID passed.' ));
        return;
    }

    $user = $request->user;

    $sql = "INSERT INTO `users` (`userId`) VALUES ('$user')";
    if(db->query($sql) !== TRUE) {
        $sqlError = $db->error;
        exit(json_encode(array( 'success' => false, 'error' => $sqlError )));
    }

    echo json_encode(array( 'success' => true ));
?>