<?php
/**
 * A general purpose class which takes and adapter and allows easy reading of the database.
 */
namespace Application\Model;

use Laminas\DB\Adapter\AdapterInterface;
use Laminas\Db\Sql\Sql;

class DatabaseReader {
    /**
     * General constants.
     */
    const MAX_IMAGE_SIZE = 10000000;  // 10MB in bytes

    /**
     * Result codes.
     */
    const NOT_FOUND = 'Not found';
    const INVALID = 'Invalid request';
    const OTHER_ERROR = 'Other error';
    const DB_ERROR = 'Database error';
    const IMG_TOO_BIG = 'Image is too big';
    const SUCCESS = 'Success';

    /**
     * The members table information.
     */
    const MEMBERS_TABLE_NAME = 'members';
    const MEMBERS_ID_FIELDNAME = 'ID';
    const MEMBERS_FIRSTNAME_FIELDNAME = 'firstname';
    const MEMBERS_SURNAME_FIELDNAME = 'surname';
    const MEMBERS_EMAIL_FIELDNAME = 'email';
    const MEMBERS_RESET_CODE_FIELDNAME = 'resetcode';
    const MEMBERS_PASSWORD_FIELDNAME = 'password';
    const MEMBERS_SALT_FIELDNAME = 'salt';
    const MEMBERS_IMAGE_FIELDNAME = 'picture';

    /**
     * The club's portsmouth numbers table information.
     */
    const PN_TABLE_NAME = 'portsmouth_numbers';
    const PN_ID_FIELDNAME = 'ID';
    const PN_CLASS_FIELDNAME = 'class';
    const PN_CONFIG_FIELDNAME = 'configuration';
    const PN_FIELDNAME = 'club_pn';

    /**
     * The database adapter.
     * @var Laminas\Authentication\Adapter\Adapter
     */
    private $dbAdapter;

    /**
     * Constructor.
     */
    public function __construct(AdapterInterface $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * Reads from the portsmouth numbers table.
     */
    public function readPN($id = NULL, $class = NULL) {
        // create the sql statement
        $sql = new SQL($this->dbAdapter);
        $select = $sql->select()->from(self::PN_TABLE_NAME);
        if ($id != NULL) {
            // read a specific ID record
            $select->where([self::PN_ID_FIELDNAME => $id]);
        } else if ($class != NULL) {
            // read a specific class record
            $select->where([self::PN_CLASS_FIELDNAME => $class]);
        }

        // execute statement and fetch results
        try {
            $PDOStatement = $sql->prepareStatementForSqlObject($select);
            $result = $PDOStatement->execute();
        } catch(\Exception $e) {
            return ['code' => self::DB_ERROR];
        }

        // check we have valid results
        if (!$result->valid()) {
            return ['code' => self::INVALID];
        } else if (!$result->isQueryResult()) {
            return ['code' => self::OTHER_ERROR];
        }

        // success! build and return array
        $returnArray = [
            'code' => self::SUCCESS,
            'results' => $result,
            'numResultsFound' => $result->getAffectedRows(),
        ];
        return $returnArray;
    }

    /**
     * Uploads a given profile picture image to a given user's record.
     *
     * Warning: does no form of validation.
     */
    public function uploadNewProfilePicture($image, $userID) {
        // check image isn't too big
        $size = $image['size'];
        if ($size > self::MAX_IMAGE_SIZE) {
            return ['code' => self::IMG_TOO_BIG];
        }

        // encode image to base64
        $tmpFileContents = file_get_contents($image['tmp_name']);
        $image64 = base64_encode($tmpFileContents);

        // create the sql statement
        $sql = new SQL($this->dbAdapter);
        $update = $sql->update(self::MEMBERS_TABLE_NAME)
            ->where([self::MEMBERS_ID_FIELDNAME => $userID])
            ->set([self::MEMBERS_IMAGE_FIELDNAME => $image64]);

        // execute statement and fetch results
        try {
            $PDOStatement = $sql->prepareStatementForSqlObject($update);
            $result = $PDOStatement->execute();
        } catch(\Exception $e) {
            return ['code' => self::DB_ERROR];
        }

        // check we have valid results
        if (!$result->valid()) {
            return ['code' => self::INVALID];
        }

        // success! build and return array
        $returnArray = [
            'code' => self::SUCCESS,
            'result' => $result,
            'image64' => $image64,
        ];
        return $returnArray;
    }
}