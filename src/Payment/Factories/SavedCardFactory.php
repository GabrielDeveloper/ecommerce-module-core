<?php

namespace Mundipagg\Core\Payment\Factories;

use Mundipagg\Core\Kernel\Interfaces\FactoryInterface;
use Mundipagg\Core\Kernel\ValueObjects\CardBrand;
use Mundipagg\Core\Kernel\ValueObjects\NumericString;
use Mundipagg\Core\Payment\Aggregates\SavedCard;
use Mundipagg\Core\Payment\ValueObjects\CardId;

class SavedCardFactory implements FactoryInterface
{
    /**
     *
     * @param  \stdClass $postData
     * @return SavedCard
     */
    public function createFromPostData($postData)
    {
        $savedCard = new SavedCard();

        $savedCard->setMundipaggId(
            new CardId($postData->id)
        );

        $savedCard->setOwnerId(
            new CustomerId('')
        );

        $brand = strtolower($postData->brand);
        $savedCard->setBrand(CardBrand::$brand());
        $savedCard->setFirstSixDigits(
            new NumericString($postData->first_six_digits)
        );
        $savedCard->setLastFourDigits(
            new NumericString($postData->last_four_digits)
        );

        return $savedCard;
    }

    /**
     *
     * @param  array $dbData
     * @return SavedCard
     */
    public function createFromDbData($dbData)
    {

    }
}