<?php
/**
 * A general purpose class which takes and adapter and allows easy reading of the database.
 */
namespace Application\Model;

use Laminas\DB\Adapter\Adapter;

class DatabaseReader {
    /**
     * Result codes.
     */
    const NOT_FOUND = 'Not found';
    const INVALID = 'Invalid request';
    const SUCCESS = 'SUCCESS';

    /**
     * The members' table name.
     */
    const MEMBERS_TABLE_NAME = 'members';

    /**
     * The club's portsmouth numbers' table name.
     */
    const PN_TABLE_NAME = 'portsmouth_numbers';

    /**
     * The database adapter.
     * @var Laminas\Authentication\Adapter\Adapter
     */
    private $dbAdapter;

    /**
     * Constructor.
     */
    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * Reads from the portsmouth numbers table.
     */
    public function readPN($table, $class = NULL, $id = NULL) {
        if ($class == NULL && $id == NULL) {
            throw new Exception('Either class or ID must be provided to get a portsmouth number.');
            return self::INVALID;
        }
    }
}