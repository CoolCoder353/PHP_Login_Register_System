<?php
class user
{
    private string $fingerprint;
    private string $username;
    private string $password;
    private string $created_at;
    private string $icon;
    private string $chats;
    private string $email;
    private bool $email_verified;

    public function get_icon(): string
    {
        return $this->icon;
    }
    public function get_username(): string
    {
        return $this->username;
    }
    public function get_created_at(): string
    {
        return $this->created_at;
    }

    public function get_email(): string
    {
        return $this->email;
    }
    public function get_email_verified(): bool
    {
        return $this->email_verified;
    }


    public function __construct(string $fingerprint)
    {
        require_once "security_functions.php";
        $fingerprint = _cleaninjections($fingerprint);
        $this->fingerprint = $fingerprint;
    }
    function login_fingerprint($token, $auto_set_to_session = true): bool
    {
        require_once "conn.php";
        require_once "security_functions.php";
        require_once "settings.php";

        if (!verify_csrf_token($token)) {
            echo "Invalid token";
            exit();
        }
        $sql = "SELECT * FROM users WHERE fingerprint=?;";

        if ($stmt = $conn->prepare($sql)) {

            $sql_fingerprint = $this->fingerprint;

            mysqli_stmt_bind_param($stmt, "s", $sql_fingerprint);
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {

                // Store result
                $result = $stmt->get_result();
                // Check if we get any rows returned
                if ($result->num_rows == 1) {
                    // Update the user's data
                    if ($row = mysqli_fetch_assoc($result)) {
                        $this->username = $row["username"];
                        $this->password = $row["password"];
                        $this->created_at = $row["created_at"];
                        $this->icon = $row["icon"];
                        $this->chats = $row["chats"];
                        $this->email = $row['email'];
                        $this->email_verified = $row['email_verified'];
                        if (FORCE_EMAIL_VERIFICATION == true && $email_verified == false) {
                            return false;
                        }
                        if ($auto_set_to_session) {
                            $_SESSION['user'] = $this;
                        }
                        return true;
                    } else {
                        echo "mysql Error of " . mysqli_error($conn);
                    }
                }
            } else {
                echo "mysql Error of " . mysqli_error($conn);
            }
        } else {
            echo "mysql Error of " . mysqli_error($conn);
        }

        return false;
    }
    function login($username, $password, $token, $auto_set_to_session = true): bool
    {
        require "conn.php";
        require_once "security_functions.php";

        if (!verify_csrf_token($token)) {
            echo "Invalid token";
            exit();
        }

        $sql = "SELECT * FROM users WHERE username=?;";

        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "sql error: " . mysqli_errno($conn);
            exit();
        } else {

            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                // Found a user entry

                /*
                    * -------------------------------------------------------------------------------
                    *   Check passwords
                    * -------------------------------------------------------------------------------
                    */
                $pwdCheck = password_verify($password, $row['password']);


                if ($pwdCheck == true) {
                    /*
                        * -------------------------------------------------------------------------------
                        *   Setup Values
                        * -------------------------------------------------------------------------------
                        */
                    $this->username = $row['username'];
                    $this->password = $row['password'];
                    $this->icon = $row['icon'];
                    $this->chats = $row['chats'];
                    $this->created_at = $row['created_at'];
                    $this->email = $row['email'];
                    $this->email_verified = $row['email_verified'];
                    if ($auto_set_to_session) {
                        $_SESSION['user'] = $this;
                    }
                    if (FORCE_EMAIL_VERIFICATION == true && $email_verified == false) {
                        return false;
                    }

                    return true;
                } else {
                    echo "wrong password";
                    exit();
                }
            } else {
                echo "username doesn't exsist";
                echo mysqli_error($conn);
                exit();
            }
        }


        return false;
    }
    function register($username, $password, $passwordRepeat, $icon, $chats, $email, $token): bool
    {

        require_once "conn.php";
        require_once "security_functions.php";
        /*
        * -------------------------------------------------------------------------------
        *   Securing against Header Injection
        * -------------------------------------------------------------------------------
        */
        $username = _cleaninjections($username);
        $password = _cleaninjections($password);
        $icon = _cleaninjections($icon);
        $email = _cleaninjections($email);
        $chats = _cleaninjections($chats);
        $token = _cleaninjections($token);

        /*
        * -------------------------------------------------------------------------------
        *   Verifying CSRF token
        * -------------------------------------------------------------------------------
        */

        if (!verify_csrf_token($token)) {
            echo "Invalid token";
            return false;
            exit();
        } else if (empty($username) || empty($password) || empty($passwordRepeat) || empty($icon) || empty($email)) {
            echo "details not set";
            return false;
            exit();
        } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            echo "no special characters in username";
            return false;
            exit();
        } else if ($password !== $passwordRepeat) {


            echo "passwords dont match";
            return false;
            exit();
        } else if (!availableUsername($conn, $username)) {

            echo "<p>username not unique</p>";
            return false;
            exit();
        }
        /*
        * -------------------------------------------------------------------------------
        *   User Creation
        * -------------------------------------------------------------------------------
        */

        $sql = "insert into users(username, password, icon, fingerprint, chats, email) 
                values (?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {


            echo "sql error of " + mysqli_errno($conn);
            return false;
            exit();
        } else {

            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
            $fingerprint = $this->fingerprint;

            mysqli_stmt_bind_param($stmt, "ssssss", $username, $hashedPwd, $icon, $fingerprint, $chats, $email);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                return $this->login($username, $password, $token);
            } else {
                echo "sql error of " . mysqli_errno($conn);
                return false;
                exit();
            }
        }
        echo "Something went wrong";
        return false;
    }
    function logout()
    {
        session_destroy();
        header("location: html/login_page.php");
        exit();
    }
}