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
 * Time: 11:08 PM
 */

namespace QuantumUnit\Filtering\Dispatch;

/**
 * FilterConfig
 *
 * @author Organization: Quantum Unit
 * @author Developer: David Meikle <david@quantumunit.com>
 */
class FilterConfig
{
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config) {
        $this->config = $config;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key) {
       return $this->config[$key] ?? null;
    }
}