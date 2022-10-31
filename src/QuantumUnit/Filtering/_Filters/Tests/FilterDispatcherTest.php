<?php
/*
 *  This file is part of the Quantum Unit Solutions development package.
 *
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
namespace QuantumUnit\Filters\Filters\Tests;
/**
 * Created by PhpStorm.
 * User: user
 * Date: 3/2/2017
 * Time: 11:42 PM
 */
class FilterDispatcherTest extends \tests\BaseTest
{


    public function testFilterRequest() {
        $filterDispatcher = new \QuantumUnit\Filters\Filters\FilterDispatcher($this->getLogger());
        $request = new \QuantumUnit\Filters\Http\Request();
        $response = new \QuantumUnit\Filters\Http\Response();
        $filterDispatcher->setContainer($this->getContainer());
        $filterDispatcher->setFilters($this->getFilters());

        $filterDispatcher->filterRequest($request, $response);
    }


    private function getFilters() {
        return array(
            array(
                'filter' => 'Gossamer\\Horus\\_Filters\\Tests\\Filter1',
            ),
            array(
                'filter' => 'Gossamer\\Horus\\_Filters\\Tests\\Filter2',
            ),
            array(
                'filter' => 'Gossamer\\Horus\\_Filters\\Tests\\Filter3'
            )
        );
    }

}