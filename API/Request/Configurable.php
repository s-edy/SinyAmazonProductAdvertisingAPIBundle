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
interface Configurable extends BasicConfigurable
{
    /**
    * The key name constants which are required parameter
    */
    const KEY_SERVICE           = 'Service';
    const KEY_VERSION           = 'Version';
    const KEY_AWS_ACCESS_KEY_ID = 'AWSAccessKeyId';
    const KEY_SECRET_ACCESS_KEY = 'SecretAccessKey';
    const KEY_ASSOCIATE_TAG     = 'AssociateTag';
    const KEY_ENDPOINT          = 'EndPoint';
    const KEY_REQUEST_URI       = 'RequestURI';

    /**
     * The key name constants which are optional parameter
     */
    const KEY_METHOD    = 'Method';
    const KEY_IS_SECURE = 'IsSecure';

    /**
     * The end points
     *
     * CA - canada
     * CN - china
     * DE - germany
     * ES - spain
     * FR - france
     * IT - italy
     * JP - japan
     * UK - united kingdom
     * US - united states of america
     */
    const ENDPOINT_CA = 'ecs.amazonaws.ca';
    const ENDPOINT_CN = 'webservices.amazon.cn';
    const ENDPOINT_DE = 'ecs.amazonaws.de';
    const ENDPOINT_ES = 'webservices.amazon.es';
    const ENDPOINT_FR = 'ecs.amazonaws.fr';
    const ENDPOINT_IT = 'webservices.amazon.it';
    const ENDPOINT_JP = 'ecs.amazonaws.jp';
    const ENDPOINT_UK = 'ecs.amazonaws.co.uk';
    const ENDPOINT_US = 'webservices.amazon.com';

    /**
     * Methods which can be used with sending a request
     */
    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';

    /**
     * Set the base parameters such as "AssociateTag" for the request.
     *
     * @param string $awsAccessKeyId  - AWS Access Key ID
     * @param string $secretAccessKey - Secret access key
     * @param string $associateTag    - Associate tag
     * @param string $endPoint        - End point
     */
    public function __construct($awsAccessKeyId, $secretAccessKey, $associateTag, $endPoint);

    /**
     * To required query data
     *
     * @return array
     */
    public function toRequiredQueryData();

    /**
     * Set an optional parameter
     * @param string $key
     * @param mixed $value
     */
    public function setOption($key, $value);
}
