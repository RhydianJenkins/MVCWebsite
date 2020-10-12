<?php
namespace Application\Model;

use Application\Model\LoginAuthAdapter;
use Laminas\Authentication\Result;
use Laminas\Authentication\Storage\Session;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Adapter;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Sql\Sql;

class LoginAuthAdapter implements AdapterInterface {
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
     * @var Laminas\Db\Adapter\Adapter
     */
    private $dbAdapter;

    /**
     * The session.
     * @var Laminas\Authentication\Storage\Session
     */
    private $session;
        
    /**
     * Constructor.
     */
    public function __construct(Session $session, Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->session = $session;
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
    public function authenticate() {                
        // query the database to check if there's a user with such username
        $sql = new SQL($this->dbAdapter);
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
            // Great! The password hash matches. Return user identity (email) to be
            // saved in session for later use.
            return new Result(Result::SUCCESS, $this->email, ['Authenticated successfully.']);        
        }             
        
        // If password check didn't pass return 'Invalid Credential' failure status.
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ['Invalid credentials.']);        
    }

    public function getDriver() {
        if ($this->driver === null) {
            throw new Exception\RuntimeException('Driver has not been set or configured for this adapter.');
        }
        return $this->driver;
    }

    public function getPlatform() {
        return $this->platform;
    }
}