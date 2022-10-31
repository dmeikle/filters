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
 * Time: 11:57 PM
 */

namespace QuantumUnit\Filters\Filters\Tests;


use QuantumUnit\Filters\Filters\AbstractFilter;
use QuantumUnit\Filters\Filters\FilterChain;
use QuantumUnit\Filters\Http\HttpRequest;
use QuantumUnit\Filters\Http\HttpResponse;

class Filter1 extends AbstractFilter
{

    public function execute(HttpRequest &$request, HttpResponse &$response, FilterChain $chain) {
       echo "this is filter1\r\n";
        throw new \Exception('throwing exception 1');
            $chain->execute($request, $response, $chain);
    }

}