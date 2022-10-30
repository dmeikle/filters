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
use QuantumUnit\Filters\Http\HttpRequest;

/**
 * LoadItemFilter
 *
 * @author Organization: Elentra Corp
 * @author Developer: David Meikle <david.meikle@elentra.com>
 */
class LoadItemFilter extends AbstractFilter
{
    /**
     * @param HttpRequest $request
     * @param FilterChain $chain
     * @return void
     */
    public function execute(HttpRequest &$request, FilterChain &$chain): void {
        $this->httpRequest = $request;

        $params = $this->filterConfig->get('params');

        if(is_null($params)) {
            $params = array();
        }
        $params['isActive'] = '1';

        $modelName = $this->filterConfig->get('model');
        $model = new $modelName($request, $this->container->get('Logger'));

        $list = $this->getEntityManager()->getConnection('datasource1')->query(self::METHOD_GET, $model, 'get', $params);

        $request->setAttribute($this->filterConfig->get('key'), $list[ $this->filterConfig->get('responseKey')]);
        $chain->execute($request, $chain);
    }
}