<?php

/**
 * Elentra ME [https://elentra.org]
 *
 * Copyright 2022 Queen's University or its assignee ("Queen's"). All Rights Reserved.
 *
 * This work is subject to Community Licenses ("CL(s)") between Queen's and its various licensee's,
 * respectively, and may only be viewed, accessed, used, reproduced, compiled, modified, copied or
 * exploited (together "Used") in accordance with a CL. Only Elentra or its licensees and their
 * respective Authorized Developers may Use this work in accordance with a CL. If you are not an
 * Authorized Developer, please contact Elentra Corporation (at info@elentra.com) or its applicable
 * licensee to review the rights and obligations under the applicable CL and become an Authorized
 * Developer before Using this work.
 *
 * @author    Organization: Elentra Corp
 * @author    Developer: David Meikle <dave.meikle@elentra.com>
 * @copyright Copyright 2022 Elentra Corporation. All Rights Reserved.
 */

namespace QuantumUnit\Filtering\Dispatch;


use QuantumUnit\Filters\Http\HttpRequest;
use QuantumUnit\Utils\Container\ContainerTrait;

/**
 * FilterDispatcher
 *
 * @author Organization: Elentra Corp
 * @author Developer: David Meikle <david.meikle@elentra.com>
 */
class FilterDispatcher
{
    use ContainerTrait;

    private $filterChain;

    private $logger;

    /**
     * @param LoggingInterface $logger
     * @param string $httpMethod
     */
    public function __construct(LoggingInterface $logger, string $httpMethod) {
        $this->filterChain = new FilterChain();
        $this->logger = $logger;
        $this->httpMethod = $httpMethod;
    }

    /**
     * @param array $filterConfig
     * @return void
     */
    public function setFilters(array $filterConfig) {

        foreach ($filterConfig as $filterParams) {

            //if it's not a matching http method skip this filter
            if(array_key_exists('method', $filterParams) && $filterParams['method'] !== $this->httpMethod) {
                continue;
            }
            $this->addFilter($filterParams);
        }
    }

    /**
     * @param array $filterParams
     * @return void
     */
    protected function addFilter(array $filterParams) {

        $filterName = $filterParams['filter'];
        $filter = null;

        if (class_exists($filterName)) {
            $filter = new $filterName($this->getFilterConfiguration($filterParams));
        } else {
            throw new \InvalidArgumentException("$filterName from bootstrap.yml does not exist");
        }

        $filter->setContainer($this->container);
        $this->filterChain->addFilter($filter);
    }

    /**
     * @param array $filterParams
     * @return FilterConfig
     */
    protected function getFilterConfiguration(array $filterParams) {
        return new FilterConfig($filterParams);
    }

    /**
     * @param HttpRequest &$request
     * @return bool
     * @throws \Exception
     *
     * runs through all filters. if the response->immediate_write is not false
     * then we found something to stop our processing of the request, and simply
     * output the response
     */
    public function filterRequest(HttpRequest &$request, &$response): bool {
        try {
            $this->filterChain->execute($request, $this->filterChain);
        } catch (\Exception $e) {
            $this->logger->addError($e->getMessage());
            throw $e;
        }
        //successful completion
        return true;
    }
}