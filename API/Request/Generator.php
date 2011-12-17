<?php
/**
 * This file is a part of Siny\Amazon\ProductAdvertisingAPIBundle package.
 *
 * (c) Shinichiro Yuki <edy@siny.jp>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Generatable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;
use \HttpQueryString;
use \DateTime;
use \DateTimeZone;

/**
 * This is a class that generate some parameters for sending to request
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
 */
class Generator implements Generatable
{
    /**
     * {@inheritdoc}
     *
     * @see Siny\Amazon\ProductAdvertisingAPIBundle\API\Request.Generatable::generateParameters()
     */
    public function generateParameters(Configurable $configuration, Requestable $request)
    {
        $timestamp = $this->getTimestamp();
        return array(
            'Timestamp' => $timestamp,
            'Signature' => $this->generateSignature($configuration, $request, $timestamp),
        );
    }

    /**
     * Get a timestamp.
     *
     * Represented in Universal Time (GMT).
     *
     * @return string - A timestamp string
     */
    public function getTimestamp()
    {
        $dateTime = new DateTime();
        return $dateTime->setTimezone(new DateTimeZone('GMT'))->format(DateTime::ISO8601);
    }

    /**
     * Generate a canonical string
     *
     * @param Configurable $configuration
     * @param Requestable $request
     * @param string $timestamp
     * @return string A canonical string
     */
    public function generateCanonicalString(Configurable $configuration, Requestable $request, $timestamp)
    {
        $parameters = array_merge(
            $configuration->toRequiredQueryData(),
            $request->getParameters(),
            array('Timestamp' => $timestamp)
        );
        ksort($parameters);

        $query = new HttpQueryString(false);
        foreach ($parameters as $key => $value) {
            $query->set(array($key => $value));
        }
        return $query->toString();
    }

    /**
     * Generate signature
     *
     * @param Configurable $configuration
     * @param Requestable $request
     * @param string $timestamp
     * @return string
     */
    public function generateSignature(Configurable $configuration, Requestable $request, $timestamp)
    {
        $seeds = array(
            $configuration->isMethodPOST() ? 'POST' : 'GET',
            $configuration->getEndPoint(),
            $configuration->getRequestURI(),
            $this->generateCanonicalString($configuration, $request, $timestamp),
        );
        $hash = hash_hmac('sha256', implode(chr(10), $seeds), $configuration->getSecretAccessKey(), true);
        return base64_encode($hash);
    }
}
