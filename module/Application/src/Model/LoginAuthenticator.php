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
use Laminas\Math\Rand;
use Laminas\Validator\Db\RecordExists;

class LoginAuthenticator extends AuthenticationService {
    /**
     * The length of the salt to add to new records.
     */
    const SALT_SIZE = 32;

    /**
     * The length of the reset string generated when the user wants to reset their password.
     */
    const RESET_CODE_LENGTH = 6;

    /**
     * The length of the salt to add to new records.
     */
    const MEMBERS_TABLE_NAME = 'members';

    /**
     * First name
     * @var string 
     */
    private $firstname;

    /**
     * Surname
     * @var string 
     */
    private $surname;
    /**
     * Email
     * @var string 
     */
    private $email;

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
     * Sets ID.
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Sets email.
     */
    public function setEmail($email) {
        $this->email = $email;        
    }
    
    /**
     * Sets first name.     
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;        
    }

    /**
     * Sets surname.     
     */
    public function setSurame($surname) {
        $this->surname = $surname;        
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
        $select = $sql->select()->from(self::MEMBERS_TABLE_NAME)->where(['email' => $this->email]);
        $PDOStatement = $sql->prepareStatementForSqlObject($select);
        $result = $PDOStatement->execute();
        $member = $result->current();

        // If there is no such user, return 'Identity Not Found' status.
        if ($member == null) {
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, null, ['Invalid credentials.']);        
        }
        
        // grab the results from the database
        $salt = $member['salt'];
        $id = $member['id'];
        $storedPasswordHash = $member['password'];
        $firstname = $member['firstname'];
        $surname = $member['surname'];

        // Now we need to calculate hash based on user-entered password and compare
        // it with the password hash stored in database.
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT, ['salt' => $salt]);
        
        // compare passwords
        if ($hashedPassword == $storedPasswordHash) {
            // successful login, get user details for identity
            $this->setId($id);
            $this->setFirstname($firstname);
            $this->setSurame($surname);

            // build user identity to save
            $identityArray = [
                'id' => $this->id,
                'firstname' => $this->firstname,
                'surname' => $this->surname,
                'email' => $this->email,
            ];

            // return user identity (name) to be saved in session for later use
            return new Result(Result::SUCCESS, $identityArray, ['Authenticated successfully.']);        
        }             
        
        // If password check didn't pass return 'Invalid Credential' failure status.
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, ['Invalid credentials.']);        
    }

    public function addNewUser(User $newUser, AdapterInterface $adapter = NULL) {

        // get information from User object
        $firstname = $newUser->getFirstname();
        $surname = $newUser->getSurname();
        $rawPassword = $newUser->getPassword();
        $email = $newUser->getEmail();

        // get sql from adapter
        if ($adapter == NULL) {
            $sql = new SQL($this->dbAdapter);
        } else {
            $sql = new SQL($adapter);
        }

        // generate a salt
        $salt = base64_encode(Rand::getBytes(self::SALT_SIZE));
        $hashedPassword = password_hash($rawPassword, PASSWORD_BCRYPT, ['salt' => $salt]);

        // build sql statement to add to database
        $insert = $sql->insert()->into(self::MEMBERS_TABLE_NAME)->values([
            'id' => NULL, 
            'password' => $hashedPassword,
            'salt' => $salt,
            'firstname' => $firstname,
            'surname' => $surname,
            'email' => $email,
        ]);
        $PDOStatement = $sql->prepareStatementForSqlObject($insert);

        // execute statement
        return $PDOStatement->execute();
    }

    /**
     * Returns true if a record exists with the given email in the database.
     */
    public function emailAlreadyExists($email, AdapterInterface $adapter = NULL) {
        // get sql from adapter
        if ($adapter == NULL) {
            $validator = new RecordExists([
                'table'   => self::MEMBERS_TABLE_NAME,
                'field'   => 'email',
                'adapter' => $this->dbAdapter,
            ]);
        } else {
            $validator = new RecordExists([
                'table'   => self::MEMBERS_TABLE_NAME,
                'field'   => 'email',
                'adapter' => $adapter,
            ]);
        }

        return $validator->isValid($email);
    }

    /**
     * Generates and returns a 6-digit reset string. This reset string will be written to the database member with the given email.
     */
    public function generateAndAddResetCode($email, AdapterInterface $adapter = NULL) {
        // generate a reset code
        $resetCode = Rand::getString(self::RESET_CODE_LENGTH);

        // get sql from adapter
        if ($adapter == NULL) {
            $sql = new SQL($this->dbAdapter);
        } else {
            $sql = new SQL($adapter);
        }
        $update = $sql
            ->update(self::MEMBERS_TABLE_NAME)
            ->where(['email' => $email])
            ->set(['resetcode' => $resetCode]);
        $PDOStatement = $sql->prepareStatementForSqlObject($update);

        // add reset code to the record
        $PDOResult = $PDOStatement->execute();

        // generate result array to return
        $resultArray = [
            'resetCode' => $resetCode,
        ];

        // return reset array
        return $resultArray;
    }
}