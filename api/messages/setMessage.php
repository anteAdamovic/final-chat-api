<?php

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $sqlError;

    if( !isset($request->conversationId) && !isset($request->userId) && !isset($request->text) ) {
        echo json_encode(array( 'success': false, 'error' => 'No conversation ID passed.' ));
        return;
	}

    $conversationId = $request->conversationId;
    $userId = $request->userId;
    $text = $request->text;
    $date = new DateTime();
    $messageId;

    // Generate unique message ID
    do {
        $messageId = generateRandomString();
    } while (!checkMessageId($messageId));

    $sql = "INSERT INTO `messages` (`conversationId`, `userId`, `text`, `date`, `messageId`) VALUES ('$conversationId', '$userId', '$text', '$date', $messageId)";

    if ($db->query($sql) === TRUE) {
        echo json_encode(array( 'success' => true ));
    } else {
        $sqlError = $db->error;
        echo json_encode(array( 'succcess' => false, 'error' => $sqlError ));
    }

    function checkMessageId($messageId) {
        $sql = "SELECT id FROM `messages` WHERE messageId='$messageId'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            return false;
        }
        return true;
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
?>