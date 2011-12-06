<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;
use \HttpQueryString;
use \DateTime;
use \DateTimeZone;

/**
 * This is a class that build a HttpRequest by the Request.
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
class Generator implements Generatable
{

    /**
     * Get a timestamp.
     *
     * and Represented in Universal Time (GMT).
     *
     * @return DateTime  - A DateTime object
     * @throws Exception - If an invalid date/time was given
     */
    public function getDateTime()
    {
        return new DateTime();
    }

    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Generatable::generateSignature()
     */
    public function generateSignature(Configurable $configuration, Requestable $request)
    {
        $seeds = array(
            $configuration->isMethodPOST() ? 'POST' : 'GET',
            $configuration->getEndPoint(),
            $configuration->getRequestURI(),
            $this->generateCanonicalString($configuration, $request, $this->getDateTime()),
        );
        $hash = hash_hmac('sha256', implode(chr(10), $seeds), $configuration->getSecretAccessKey(), true);
        return rawurlencode(base64_encode($hash));
    }

    private function generateCanonicalString(Configurable $configuration, Requestable $request)
    {
        $parameters = array_merge(
            $configuration->toRequiredQueryData(),
            $request->getParameters(),
            array('Timestamp' => $this->getDateTime()->setTimezone(new DateTimeZone('GMT'))->format(DateTime::ISO8601))
        );
        ksort($parameters);

        $query = new HttpQueryString(false);
        foreach ($parameters as $key => $value) {
            $query->set(array($key => $value));
        }
        return $query->toString();
    }
}
