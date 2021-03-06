<?php
/**
 * Copied and adapted from Magento 2.2.2 Magento\Braintree\Model\CvvEmsCodeMapper
 *
 * This version uses less classes and it is compatible with any Magento 2 version
 */
namespace Signifyd\Connect\Model\Payment\Braintree;

use Signifyd\Connect\Model\Payment\Base\CvvEmsCodeMapper as Base_CvvEmsCodeMapper;

/**
 * Processes CVV codes mapping from Braintree transaction to
 * electronic merchant systems standard.
 *
 * @see https://developers.braintreepayments.com/reference/response/transaction
 * @see http://www.emsecommerce.net/avs_cvv2_response_codes.htm
 */
class CvvEmsCodeMapper extends Base_CvvEmsCodeMapper
{
    protected $allowedMethods = array('braintree');

    /**
     * List of mapping CVV codes
     *
     * @var array
     */
    private static $cvvMap = [
        'M' => 'M',
        'N' => 'N',
        'U' => 'P',
        'I' => 'P',
        'S' => 'S',
        'A' => ''

    ];

    /**
     * Gets payment CVV verification code.
     *
     * @param \Magento\Sales\Api\Data\OrderPaymentInterface $orderPayment
     * @return string
     * @throws \InvalidArgumentException If specified order payment has different payment method code.
     */
    public function getPaymentData(\Magento\Sales\Api\Data\OrderPaymentInterface $orderPayment)
    {
        $additionalInfo = $orderPayment->getAdditionalInformation();
        if (empty($additionalInfo['cvvResponseCode'])) {
            return parent::getPaymentData($orderPayment);
        }

        $cvv = $additionalInfo['cvvResponseCode'];

        if (isset(self::$cvvMap[$cvv]) && $this->validate(self::$cvvMap[$cvv])) {
            return self::$cvvMap[$cvv];
        } else {
            return parent::getPaymentData($orderPayment);
        }
    }
}
