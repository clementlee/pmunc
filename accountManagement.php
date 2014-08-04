<?php
include_once('config1.php');

if(isset($_POST['updateUserSubmit']) && $_POST['updateUserSubmit'] == 'true') {
    $id = trim($_POST['id']);
    $email = trim($_POST['email']);
    $lName = trim($_POST['lName']);
    $fName = trim($_POST['fName']);
    $userType = (int) $_POST['user_type'];

    if (!eregi("^[^@]{1,64}@[^@]{1,255}$", $registerEmail))
        $errors['registerEmail'] = 'Your email address is invalid.';

    if(strlen($registerPassword) < 6 || strlen($registerPassword) > 12)
        $errors['registerPassword'] = 'Your password must be between 6-12 characters.';

    if($registerPassword != $registerConfirmPassword)
        $errors['registerConfirmPassword'] = 'Your passwords did not match.';

    $query = 'SELECT * FROM users';
    $result = mysql_query($query);


    if(!$errors) {
        $query = 'INSERT INTO users SET first_name="' 
            . $fName 
            . '", last_name="' 
            . $lName 
            . '", email = "' 
            . $registerEmail 
            . '", password=MD5("' 
            . $registerPassword 
            . '"), user_type = ' 
            . $userType 
            . ';';

        if(mysql_query($query)) {
            $success['register'] = 'Thank you for adding a new account. You can now log in.';
        }
        else {
            $errors['register'] = 'There was a problem registering you. Please check your details and try again.';
        }
    }
}
?>
