<?php
/*
 *  This file is part of the Quantum Unit Solutions development package.
 *
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

/**
 * Created by PhpStorm.
 * User: user
 * Date: 3/2/2017
 * Time: 11:10 PM
 */

namespace QuantumUnit\Filtering\Dispatch;


use QuantumUnit\Filtering\Filters\AbstractFilter;
use QuantumUnit\Filtering\Http\HttpRequest;

/**
 * FilterChain
 *
 * @author Organization: Quantum Unit
 * @author Developer: David Meikle <david@quantumunit.com>
 */
class FilterChain
{

    private $filters = [];/*


    /**
     * @param AbstractFilter $filter
     * @return void
     */
    public function addFilter(AbstractFilter $filter): void
    {
        $this->filters[] = $filter;
    }

    /**
     * @param HttpRequest $request
     * @param FilterChain $chain
     * @return void
     */
    public function execute(HttpRequest &$request, FilterChain &$chain): void {
        $filter = $this->next();
echo "\r\nhere";
        if($filter !== false) {
            echo "\r\nhave filter";
            //need to pass in for other methods deeper than the called method
            $filter->setHttpRequest($request);
            $filter->execute($request, $chain);
        }
    }

    /**
     * @return false|mixed|null
     */
    private function next() {
        if(count($this->filters) > 0) {
            return array_shift($this->filters);
        }

        return false;
    }
}