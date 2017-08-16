<?php

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $sqlError;

    if( !isset($request->user) ) {
        echo json_encode(array( 'success' => false, 'error' => 'No user ID passed.' ));
        return;
	}

    $user = $request->user;

    $sql = "SELECT conversationId FROM `conversations` WHERE userId='$user'";
    $result = $db->query($sql);

    $data = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($data, $row['conversationId']);
        }
    } else {
        $sqlError = $db->error;
        echo json_encode(array( 'success' => false, 'data' => 'No conversations found.', 'error' => $sqlError ));
    }

    echo json_encode(array( 'success' => true, 'data' => $data ));

?>