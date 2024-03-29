<?php

namespace Mundipagg\Core\Kernel\Repositories;

use Mundipagg\Core\Kernel\Abstractions\AbstractDatabaseDecorator;
use Mundipagg\Core\Kernel\Abstractions\AbstractEntity;
use Mundipagg\Core\Kernel\Abstractions\AbstractRepository;
use Mundipagg\Core\Kernel\Aggregates\Order;
use Mundipagg\Core\Kernel\Factories\OrderFactory;
use Mundipagg\Core\Kernel\ValueObjects\AbstractValidString;

final class OrderRepository extends AbstractRepository
{
    /**
     *
     * @param  Order $object
     * @throws \Exception
     */
    protected function create(AbstractEntity &$object)
    {
        $orderTable = $this->db->getTable(AbstractDatabaseDecorator::TABLE_ORDER);

        $order = json_decode(json_encode($object));

        $query = "
          INSERT INTO $orderTable (`mundipagg_id`, `code`, `status`) 
          VALUES ('{$order->mundipaggId}', '{$order->code}', '{$order->status}');
         ";

        $this->db->query($query);

        $chargeRepository = new ChargeRepository();
        foreach ($object->getCharges() as $charge) {
            $chargeRepository->save($charge);
            $object->updateCharge($charge, true);
        }
    }

    /**
     *
     * @param  Order $object
     * @throws \Exception
     */
    protected function update(AbstractEntity &$object)
    {
        $order = json_decode(json_encode($object));
        $orderTable = $this->db->getTable(AbstractDatabaseDecorator::TABLE_ORDER);

        $query = "
            UPDATE $orderTable SET
              status = '{$order->status}'
            WHERE id = {$order->id}
        ";

        $this->db->query($query);

        //update Charges;
        $chargeRepository = new ChargeRepository();
        foreach ($object->getCharges() as $charge) {
            $chargeRepository->save($charge);
            $object->updateCharge($charge, true);
        }
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
        $orderTable = $this->db->getTable(AbstractDatabaseDecorator::TABLE_ORDER);

        $query = "SELECT * FROM `$orderTable` ";
        $query .= "WHERE mundipagg_id = '{$id}';";

        $result = $this->db->fetch($query);

        if ($result->num_rows === 0) {
            return null;
        }

        $factory = new OrderFactory();

        return $factory->createFromDbData($result->row);
    }

    public function listEntities($limit, $listDisabled)
    {
        // TODO: Implement listEntities() method.
    }
}