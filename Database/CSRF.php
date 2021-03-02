<?php
class CSRF
{
    public static function create_token()
    {
        // Generating a unique token
        $token = md5(time());

        // Saving the token in session
        $_SESSION["token"] = $token;

        // Creating a hidden input field with that unique input
        echo "<input type='hidden' name='csrf_token' value='" . $token . "' />";
    }

    public static function validate_token($token)
    {
        if (!isset($_SESSION["token"]))
        {
            return false;
        }

        if ($_SESSION["token"] != $token)
        {
            return false;
        }
        return true;
    }
}