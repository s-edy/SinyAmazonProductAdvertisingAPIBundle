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

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Configurable as BasicConfigurable;

/**
 * This is a class to configure the basic parameters
 * for the Amazon Product Advertising API
 *
 * @package SinyAmazonProductAdvertisingAPI
 * @subpackage API
 * @author Shinichiro Yuki <edy@siny.jp>
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
     * Get a secret access key
     */
    public function getSecretAccessKey();

    /**
     * Get an End point
     *
     * @see Configurable::ENDPOINT_CA
     * @see Configurable::ENDPOINT_CN
     * @see Configurable::ENDPOINT_DE
     * @see Configurable::ENDPOINT_ES
     * @see Configurable::ENDPOINT_FR
     * @see Configurable::ENDPOINT_IT
     * @see Configurable::ENDPOINT_JP
     * @see Configurable::ENDPOINT_UK
     * @see Configurable::ENDPOINT_US
     *
     * @return string
     */
    public function getEndPoint();

    /**
     * Get a Request URI
     *
     * @return string
     */
    public function getRequestURI();

    /**
     * Whether it is secure
     *
     * @return boolean
     */
    public function isSecure();

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

    /**
     * Set an optional parameter
     * @param string $key
     * @param mixed $value
     */
    public function setOption($key, $value);
}
