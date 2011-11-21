<?php
/**
 * This file is a part of SinyAmazonProductAdvertisingAPIBundle package.
 *
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */

namespace Siny\Amazon\ProductAdvertisingAPIBundle\API\Request;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Configurable as BasicConfigurable;

/**
 * This is a class to configure the basic parameters
 * for the Amazon Product Advertising API
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <sinycourage@gmail.com>
 */
interface RequestConfigurable extends BasicConfigurable
{
    /**
     * Set the base parameters such as "AssociateTag" for the request.
     *
     * @param string $awsAccessKeyId  - AWS Access Key ID
     * @param string $secretAccessKey - Secret access key
     * @param string $associateTag    - Associate tag
     * @param string $locale          - Specify the locale to request to Amazon
     *                                - From the locale constants (ex: Request::LOCALE_JP)
     * @throws RequstConfigurationException - Will occur if the wrong locale is set
     */
    public function __construct($awsAccessKeyId, $secretAccessKey, $associateTag, $locale, array $options = array());

    /**
     * Get Service name
     *
     * @return string Service name
     */
    public function getServiceName();

    /**
     * Get AWS Access key ID
     *
     * @return string
     */
    public function getAWSAccessKeyId();

    /**
     * Get Secret access key
     * @return string
     */
    public function getSecretAccessKey();

    /**
     * Get Associate tag
     * @return string
     */
    public function getAssociateTag();

    /**
     * Get version
     *
     * @return string Using API version
     */
    public function getVersion();

    /**
     * Get DateTime
     *
     * @return \DateTime
     */
    public function getTimestamp();

    /**
     * Get end point
     *
     * @return string
     */
    public function getEndPoint();

    /**
     * Is secure request
     *
     * whethere a request send securely
     *
     * @return boolean
     */
    public function isSecureRequest();

    /**
     * Is method GET ?
     *
     * @return boolean
     */
    public function isMethodGET();

    /**
     * Is method POST ?
     *
     * @return boolean
     */
    public function isMethodPOST();
}
