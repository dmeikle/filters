<?php
/*
 *  This file is part of the Quantum Unit Solutions development package.
 *
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Tests\QuantumUnit\Filtering\Dispatch;


use QuantumUnit\Filtering\Dispatch\FilterDispatcher;
use QuantumUnit\Filtering\Http\HttpRequest;
use QuantumUnit\Filtering\Http\RequestParams;
use QuantumUnit\Filtering\Http\SiteParams;
use QuantumUnit\Utils\Container\Container;
use QuantumUnit\Utils\Logging\MonologLogger;
use QuantumUnit\Utils\Yaml\YamlLoader;
use tests\BaseTest;

/**
 * FilterDispatcherTest
 *
 * @author Organization: Quantum Unit
 * @author Developer: David Meikle <david@quantumunit.com>
 */
class FilterDispatcherTest extends BaseTest
{

    /**
     * @test
     * @return void
     * @throws \QuantumUnit\Utils\Exceptions\FileNotFoundException
     */
    public function load_dispatcher__should_return_dispatcher(): void
    {
        $siteParams = new SiteParams();
        $requestParams = new RequestParams();
        $httpRequest = new HttpRequest($requestParams,$siteParams);
        $config = YamlLoader::loadConfig(__INPUT_PATH . 'filters.yml');
        $container = new Container();
        $dispatcher = new FilterDispatcher(new MonologLogger('test'), 'GET', $container, $config['test_filter_1']);

        $result = $dispatcher->filterRequest($httpRequest);
        $this->assertTrue($result);
    }
}