<?php
/*
 *  This file is part of the Quantum Unit Solutions development package.
 *
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace QuantumUnit\Filtering\Config;


/**
 * FilterEvents
 *
 * @author Organization: Quantum Unit
 * @author Developer: David Meikle <david@quantumunit.com>
 */
class FilterEvents
{
    public const FILTER_REQUEST_START = 'request_start';
    public const FILTER_REQUEST_FORWARD = 'request_forward';
    public const FILTER_ENTRY_POINT = 'entry_point';
    public const FILTER_SERIALIZATION = 'request_serialize';
}