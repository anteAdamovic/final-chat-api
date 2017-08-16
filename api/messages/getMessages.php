<?php

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $sqlError;

    if( !isset($request->conversationId) ) {
        echo json_encode(array( 'success': false, 'error' => 'No conversation ID passed.' ));
        return;
	}

    $conversationId = $request->conversationId;

    $sql = "SELECT * FROM `messages` WHERE conversationId='$conversationId'";
    $result = $db->query($sql);
    $data = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    } else {
        $sqlError = $db->error;
        echo json_encode(array( 'success' => false, 'data' => 'No messages found.', 'error' => $sqlError ));
    }

    echo json_encode(array( 'success' => true, 'data': $data ));
?>