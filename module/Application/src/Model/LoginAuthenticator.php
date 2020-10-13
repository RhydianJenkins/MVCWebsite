<?php
namespace Application\Model;

use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Result;
use Laminas\Authentication\Storage\Session;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Adapter;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Sql\Sql;
use Application\Model\User;

class LoginAuthenticator extends AuthenticationService {
    /**
     * Username.
     * @var string 
     */
    private $username;
    
    /**
     * Password
     * @var string 
     */
    private $password;
    
    /**
     * The database adapter.
     * @var Laminas\Authentication\Adapter\Adapter
     */
    private $dbAdapter;
        
    /**
     * Constructor.
     */
    public function __construct(Session $session, Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->setStorage($session);
    }
    
    /**
     * Sets username.     
     */
    public function setUsername($username) {
        $this->username = $username;        
    }
    
    /**
     * Sets password.     
     */
    public function setPassword($password) {
        $this->password = (string)$password;        
    }
    
    /**
     * Performs an authentication attempt.
     */
    public function authenticate(AdapterInterface $adapter = NULL) {                
        // query the database to check if there's a user with such username
        if ($adapter == NULL) {
            $sql = new SQL($this->dbAdapter);
        } else {
            $sql = new SQL($adapter);
        }
        $select = $sql->select()->from('members')->where(['username' => $this->username]);
        $PDOStatement = $sql->prepareStatementForSqlObject($select);
        $result = $PDOStatement->execute();
        $member = $result->current();

        // If there is no such user, return 'Identity Not Found' status.
        if ($member==null) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, ['Invalid credentials.']);        
        }
        
        // Now we need to calculate hash based on user-entered password and compare
        // it with the password hash stored in database.
        $salt = $member['salt'];
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT, ['salt' => $salt]);
        $storedPasswordHash = $member['password'];

        // compare passwords
        if ($hashedPassword == $storedPasswordHash) {
            // Great! The password hash matches. Return user identity (username) to be
            // saved in session for later use.
            return new Result(Result::SUCCESS, $this->username, ['Authenticated successfully.']);        
        }             
        
        // If password check didn't pass return 'Invalid Credential' failure status.
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ['Invalid credentials.']);        
    }

    public function addNewUser(User $newUser) {
        echo("<pre>"); var_dump($newUser); echo("</pre>");
    }
}