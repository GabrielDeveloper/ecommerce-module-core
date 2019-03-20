<?php

namespace Mundipagg\Core\Payment\Repositories;

use Mundipagg\Core\Kernel\Abstractions\AbstractDatabaseDecorator;
use Mundipagg\Core\Kernel\Abstractions\AbstractEntity;
use Mundipagg\Core\Kernel\Abstractions\AbstractRepository;
use Mundipagg\Core\Kernel\Exceptions\InvalidParamException;
use Mundipagg\Core\Kernel\ValueObjects\AbstractValidString;
use Mundipagg\Core\Payment\Aggregates\SavedCard;

final class SavedCardRepository extends AbstractRepository
{
    /** @param SavedCard $object */
    protected function create(AbstractEntity &$object)
    {
        $table = $this->db->getTable(AbstractDatabaseDecorator::TABLE_SAVED_CARD);

        $obj = json_decode(json_encode($object));

        if ($object->getOwnerId() === null)
        {
            throw new InvalidParamException('
            You can\'t save a card withou an onwer!' , null
            );
        }

        $query = "
          INSERT INTO $table 
            (
                mundipagg_id, 
                owner_id, 
                first_six_digits, 
                last_four_digits,
                brand
            )
          VALUES 
            (
                '{$obj->mundipaggId}',
                '{$obj->ownerId}',
                '{$obj->firstSixDigits}',
                '{$obj->lastFourDigits}',
                '{$obj->brand}',          
            )          
        ";

        $this->db->query($query);
    }

    protected function update(AbstractEntity &$object)
    {
        // TODO: Implement update() method.
    }

    public function delete(AbstractEntity $object)
    {
        // TODO: Implement delete() method.
    }

    public function find($objectId)
    {
        // TODO: Implement find() method.
    }

    public function findByMundipaggId(AbstractValidString $mundipaggId)
    {
        $id = $mundipaggId->getValue();
        $table = $this->db->getTable(AbstractDatabaseDecorator::TABLE_SAVED_CARD);
        $query = "SELECT * FROM $table WHERE mundipagg_id = '$id'";

        $result = $this->db->fetch($query);

        if ($result->num_rows > 0) {
            $factory = new SavedCardFactory();
            $webhook = $factory->createFromDbData($result->row);

            return $webhook;
        }
        return null;
    }

    public function listEntities($limit, $listDisabled)
    {
        // TODO: Implement listEntities() method.
    }
}