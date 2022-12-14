<?php
/*
 *  This file is part of the Quantum Unit Solutions development package.
 *
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace QuantumUnit\Filtering\Dispatch;


use QuantumUnit\Filtering\Http\HttpRequest;
use QuantumUnit\Utils\Container\Container;
use QuantumUnit\Utils\Container\ContainerTrait;
use QuantumUnit\Utils\Logging\Contracts\LoggingInterface;

/**
 * FilterDispatcher
 *
 * @author Organization: Quantum Unit
 * @author Developer: David Meikle <david@quantumunit.com>
 */
class FilterDispatcher
{
    use ContainerTrait;

    private $filterChain;

    private $logger;

    /**
     * @param LoggingInterface $logger
     * @param string $httpMethod
     * @param array $filterConfig
     */
    public function __construct(LoggingInterface $logger, string $httpMethod, Container $container, array $filterConfig = []) {
        $this->filterChain = new FilterChain();
        $this->logger = $logger;
        $this->httpMethod = $httpMethod;
        $this->container = $container;
        $this->setFilters($filterConfig);
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
    public function filterRequest(HttpRequest &$request): bool {
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