<?php

    $postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
    $sqlError;

    if( !isset($request->users) ) {
        echo json_encode({ success: false, error: "No user IDs passed." });
        return;
	}

    $users = $request->users;

    // First check if all users exist
    foreach($users as &$user) {
        if (!userExists($user)) {
            exit(json_encode({ success: false, data: "Can't find user '$user'", error: $sqlError }));
        }
    }

    $conversationId

    // Make sure conversationId doesn't exist already
    do {
        $conversationId = generateRandomString();
    } while (!conversationExists($conversationId));

    foreach($users as &$user) {
        if (!addNewConversation($user, $conversationId)) {
            exit(json_encode({ success: false, data: "Couldn't create conversation '$conversationId' for user '$user'", error: $sqlError }))
        }
    }

    echo json_encode({ success: true });

    // Functions

    function userExists($userId) {
        $sql = "SELECT id FROM `users` WHERE userId='$userId'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            return true;
        }

        $sqlError = $db->error;
        return false;
    }

    function conversationExists($conversationId) {
        $sql = "SELECT id FROM `conversations` WHERE conversationId='$conversationId'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            return true;
        }

        $sqlError = $db->error;
        return false;
    }

    function addNewConversation($userId, $conversationId) {
        $sql = "INSERT INTO `conversations` (`conversationId`, `userId`) VALUES ('$conversationId', '$userId')";
        if ($db->query($sql) === TRUE) {
            return true;
        }

        $sqlError = $db->error;
        return false;
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