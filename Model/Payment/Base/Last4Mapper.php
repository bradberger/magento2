<?php

namespace Signifyd\Connect\Model\Payment\Base;

use Signifyd\Connect\Model\Payment\DataMapper;

class Last4Mapper extends DataMapper
{
    /**
     * Gets last 4 credit card digits on Magento's default location on database
     *
     * @param \Magento\Sales\Api\Data\OrderPaymentInterface $orderPayment
     * @return null|string
     */
    public function getPaymentData(\Magento\Sales\Api\Data\OrderPaymentInterface $orderPayment)
    {
        $last4 = $orderPayment->getCcLast4();
        $last4 = is_null($last4) ? '' : $last4;
        return $last4;
    }
}
