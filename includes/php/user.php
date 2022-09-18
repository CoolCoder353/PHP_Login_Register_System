<?php
class user
{
    private string $fingerprint;
    private string $username;
    private string $password;
    private string $created_at;
    private string $icon;
    private string $chats;



    public function __construct(string $fingerprint)
    {
        $this->fingerprint = $fingerprint;
    }
    function login_fingerprint($token) : bool
    {
        require_once "conn.php";
        require_once "security_functions.php";

        if (!verify_csrf_token($token)) {
            echo "Invalid token";
            exit();
        }
        $sql = "SELECT * FROM user WHERE fingerprint=?;";

        if ($stmt = $conn->prepare($sql))
        {
            
            $sql_fingerprint= $this->fingerprint;

            mysqli_stmt_bind_param($stmt, "s", $sql_fingerprint);
            // Attempt to execute the prepared statement
            if ($stmt->execute())
            {
            
                // Store result
                $result = $stmt->get_result();
                // Check if we get any rows returned
                if ($result->num_rows == 1)
                {
                    // Update the user's data
                    if ($row = mysqli_fetch_assoc($result)) {
                        $this->username = $row["username"];
                        $this->password = $row["password"];
                        $this->created_at = $row["created_at"];
                        $this->icon = $row["icon"];
                        $this->chats = $row["chats"];
                        return true;
                    }else
                    {
                        echo "mysql Error of ". mysqli_error($conn);
                    }
                    
                }
            }else
            {
                echo "mysql Error of ". mysqli_error($conn);
            }
        }else
        {
            echo "mysql Error of ". mysqli_error($conn);
        }
        
        return false;
    }
    function login($username, $password, $token) : bool
    {
        require_once "conn.php";
        require_once "security_functions.php";

        if (!verify_csrf_token($token)) {
            echo "Invalid token";
            exit();
        }
        
        $sql = "SELECT * FROM user WHERE username=?;";

        $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "sql error: " + mysqli_errno($conn);
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


                    if ($pwdCheck == false) {
                        echo "wrong password";
                        exit();
                    } else if ($pwdCheck == true) {
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

                        
                    }
                } else {
                    echo "username doesn't exsist";
                    exit();
                }
            }


        return false;
    }
    function register($username, $password, $icon, $chats, $token) : bool
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
        $fingerprint = _cleaninjections($fingerprint);
        $chats = implode(_cleaninjections($chats));
        $token = _cleaninjections($token);

        
        /*
        * -------------------------------------------------------------------------------
        *   Verifying CSRF token
        * -------------------------------------------------------------------------------
        */

        if (!verify_csrf_token($token)) {
            echo "Invalid token";
            exit();
        }
        if (empty($username) || empty($password) || empty($passwordRepeat)) {
            echo "details not set";
            exit();
        } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            echo "no special characters in username";
            exit();
        }  else if ($password !== $passwordRepeat) {
    
            
            echo "passwords dont match";
            exit();
        } else {
            if (!availableUsername($conn, $username)){
                echo "username not unique";
                exit();
            }
        }
        /*
        * -------------------------------------------------------------------------------
        *   User Creation
        * -------------------------------------------------------------------------------
        */

        $sql = "insert into user(username, password, icon, fingerprint, chats) 
                values (?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {

           
            echo "sql error of " + mysqli_errno($conn);
            exit();
        } 
        else {

            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt, "sssss", $username, $hashedPwd, $icon, $fingerprint, $chats);
            if(mysqli_stmt_execute($stmt))
            {
                return $this->login($username, $password, $token);
            }
            

           
            
        }
    }
    

}

class user_settings
{
    public string $test;
}
