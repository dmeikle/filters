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

namespace QuantumUnit\Filters\Filters;


use QuantumUnit\Filters\Http\HttpRequest;

class ListAllFilter extends AbstractFilter
{
    public function execute(HttpRequest &$request, FilterChain &$chain) {
        $this->httpRequest = $request;

        $params = $this->filterConfig->get('params') ?? [];

        $params['isActive'] = '1';

        $modelName = $this->filterConfig->get('model');
        $model = new $modelName($request, $this->container->get('Logger'));

        $list = $this->getEntityManager()->getConnection(
            $this->filterConfig->get('datasource')
        )->query(self::METHOD_GET, $model, 'listminimal', $params);

        $request->setAttribute($this->filterConfig->get('key'), $list[ $this->filterConfig->get('responseKey')]);

        $chain->execute($request, $chain);

    }
}