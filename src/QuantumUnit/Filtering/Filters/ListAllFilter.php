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
 * Date: 10/28/2017
 * Time: 7:25 PM
 */

namespace QuantumUnit\Filtering\Filters;


use QuantumUnit\Filtering\Dispatch\FilterChain;
use QuantumUnit\Filtering\Http\HttpRequest;

/**
 * ListAllFilter
 *
 * @author Organization: Quantum Unit
 * @author Developer: David Meikle <david@quantumunit.com>
 */
class ListAllFilter extends AbstractFilter
{
    /**
     * @param HttpRequest $request
     * @param FilterChain $chain
     * @return void
     */
    public function execute(HttpRequest &$request, FilterChain &$chain): void {
        $this->httpRequest = $request;

        $params = $this->filterConfig->get(self::PARAMS) ?? [];

        $params['isActive'] = '1';

        $modelName = $this->filterConfig->get(self::MODEL);
        $model = new $modelName($request, $this->container->get(self::LOGGER));

        $list = $this->getEntityManager()->getConnection(
            $this->filterConfig->get(self::DATASOURCE)
        )->query(self::METHOD_GET, $model, 'listminimal', $params);

        $request->setAttribute(
            $this->filterConfig->get(self::KEY),
            $list[$this->filterConfig->get(self::RESPONSE_KEY)]
        );

        $chain->execute($request, $chain);

    }
}