<?php
namespace Application\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class MemberTable {
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        return $this->tableGateway->select();
    }

    public function getMember($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveMember(Member $member) {
        $data = [
            'name' => $member->name,
            'email'  => $member->email,
        ];

        $id = (int) $member->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getMember($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update member with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteMember($id) {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
