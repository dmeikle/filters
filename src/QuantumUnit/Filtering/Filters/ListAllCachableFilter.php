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
 * ListAllCachableFilter
 *
 * @author Organization: Quantum Unit
 * @author Developer: David Meikle <david@quantumunit.com>
 */
class ListAllCachableFilter extends AbstractCachableFilter
{
    /**
     * @param HttpRequest $request
     * @param FilterChain $chain
     * @return void
     */
    public function execute(HttpRequest &$request, FilterChain &$chain): void {

        $list = $this->retrieveFromCache();

        if($list === false) {
            $list = $this->listValues($request);
            $this->saveToCache($list);
        }
        $request->setAttribute(
            $this->filterConfig->get(self::KEY),
            $list
        );

        $chain->execute($request, $chain);
    }

    protected function listValues(\QuantumUnit\Filtering\Http\HttpRequest &$request)
    {
        $this->httpRequest = $request;

        $params = $this->filterConfig->get(self::PARAMS) ?? [];

        $params['isActive'] = '1';

        $modelName = $this->filterConfig->get(self::MODEL) ?? null;
        $model = $modelName !== null ? new $modelName($request, $this->container->get(self::LOGGER)) : null;

        $datasource = ($this->filterConfig->get(self::DATASOURCE));

        if($datasource === self::LOCAL_DATASOURCE) {
            return $this->queryModel($request, $model, $params);
        }

        $list = $this->getEntityManager()->getConnection(
            $this->filterConfig->get(self::DATASOURCE)
        )->execute(
            self::METHOD_GET,
            $model,
            $this->filterConfig->get(self::SERVICE_FUNCTION),
            $params
        );

        return $list[$this->filterConfig->get(self::RESPONSE_KEY)];
    }
}