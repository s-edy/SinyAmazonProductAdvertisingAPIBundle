<?php
/**
* This file is a part of Siny\Amazon\ProductAdvertisingAPIBundle package.
*
* (c) Shinichiro Yuki <edy@siny.jp>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Siny\Amazon\ProductAdvertisingAPIBundle\Tests;

use Siny\Amazon\ProductAdvertisingAPIBundle\API\Sender;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configurable;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Configuration;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Builder;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Request\Request;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Operation\BrowseNodeLookupOperation;
use Siny\Amazon\ProductAdvertisingAPIBundle\API\Response;

class ExampleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * This is example
     *
     * @test
     */
    public function example()
    {
        // Configuration variables
        $awsAccessKeyId  = 'XXXXXXXXXXXXXXXXXXXX';
        $secretAccessKey = 'YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY';
        $associateTag    = 'ZZZZZZZZZZZ';
        $endPoint        = Configurable::ENDPOINT_JP;

        // Operation variable
        $browseNodeId = '999999';

        // Build a sender
        $configuration = new Configuration($awsAccessKeyId, $secretAccessKey, $associateTag, $endPoint);
        $builder = new Builder($configuration);
        $sender = new Sender($builder);

        // make a new Operation
        $operation = new BrowseNodeLookupOperation($browseNodeId);

        // create a sending request
        $request = new Request($operation);

        // send
        $response = $sender->send($request);
    }
}

