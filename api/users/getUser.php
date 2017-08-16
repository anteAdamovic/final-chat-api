<?php

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $sqlError;

    if( !isset($request->user) ) {
        echo json_encode(array( 'success' => false, 'error' => 'No user ID passed.' ));
        return;
    }

    $user = $request->user;

    $sql = "SELECT * FROM `users` WHERE userId='$user'";
    $result = $db->query($sql);
    if ($result->num_rows <= 0) {
        $sqlError = $db->error;
        exit(json_encode(array( 'success' => false, 'error' => $sqlError )));
    }

    echo json_encode(array( 'success' => true ));
?>