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
 * Date: 10/29/2017
 * Time: 10:00 PM
 */

namespace QuantumUnit\Filters\Filters;


class AbstractCachableFilter extends AbstractFilter
{


    public function retrieveFromCache() {
        $key = $this->filterConfig->get('cacheKey');
        $result = $this->container->get('CacheManager')->retrieveFromCache($key);

        if(!is_array($result) || count($result) == 0) {
            return false;
        }

        return $result;
    }

    public function saveToCache($values, $key = null) {
        $key = $this->filterConfig->get('cacheKey');

        return $this->container->get('CacheManager')->saveToCache($key, $values);
    }
}