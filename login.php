<?php

// if name is not in the post data, exit
if (!isset($_POST["name"])) {
    header("Location: error.html");
    exit;
}
///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
// $ext = end(explode('.', $filename));
// alert("x");


			move_uploaded_file($_FILES['profile_picture']['tmp_name'], $_FILES['profile_picture']['name']);

        $extension = end(explode('.', $_FILES['profile_picture']['name']));
        	$image_location = 'image/' . $_POST["name"] . '.' .$_POST[profile_picture];

        	        	// $image_location = 'image/' . $_POST["name"] . '.' .$extension;

	///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////

require_once('xmlHandler.php');

// create the chatroom xml file handler
$xmlh = new xmlHandler("chatroom.xml");
if (!$xmlh->fileExist()) {
    header("Location: error.html");
    exit;
}

// open the existing XML file
$xmlh->openFile();

// get the 'users' element
$users_element = $xmlh->getElement("users");

// create a 'user' element
$user_element = $xmlh->addElement($users_element, "user");

// add the user name
$xmlh->setAttribute($user_element, "name", $_POST["name"]);


///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
$xmlh->setAttribute($user_element, "picture", $image_location);    
///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////
///////////////////////////////////////




// save the XML file
$xmlh->saveFile();

// set the name to the cookie
setcookie("name", $_POST["name"]);

// Cookie done, redirect to client.php (to avoid reloading of page from the client)
header("Location: client.php");

?>
