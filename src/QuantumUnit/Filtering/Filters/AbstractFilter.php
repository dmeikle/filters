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

namespace QuantumUnit\Filtering\Filters;

 
use QuantumUnit\Filtering\Dispatch\FilterChain;
use QuantumUnit\Filtering\Dispatch\FilterConfig;
use QuantumUnit\Filtering\Http\HttpRequest;
use Gossamer\Pesedget\Database\DatasourceFactory;
use QuantumUnit\Utils\Container\ContainerTrait;

class AbstractFilter
{
    use ContainerTrait;

    protected $datasourceFactory;

    protected $filterConfig;

    protected $params = null;

    protected $httpRequest;

    protected $httpResponse;

    const METHOD_DELETE = 'delete';
    const METHOD_SAVE = 'save';
    const METHOD_PUT = 'put';
    const METHOD_POST = 'post';
    const METHOD_GET = 'get';
    const VERB_LIST = 'list';
    const VERB_DELETE = 'delete';
    const VERB_GET = 'get';
    const VERB_SEARCH = 'search';
    const VERB_SAVE = 'save';
    const DIRECTIVES = 'directives';

    const DATASOURCE = 'datasource';
    const PARAMS = 'params';
    const LOGGER = 'logger';
    const MODEL = 'model';
    const KEY = 'key';
    const RESPONSE_KEY = 'responseKey';

    /**
     * AbstractFilter constructor.
     * @param FilterConfig $config
     * @param array|null $params
     */
    public function __construct(FilterConfig $config, array $params = null) {
        $this->filterConfig = $config;
        $this->params = $params;
    }

    /**
     * @param HttpRequest $httpRequest
     * @return void
     */
    public function setHttpRequest(HttpRequest $httpRequest) {
        $this->httpRequest = $httpRequest;
    }

    /**
     * @param DatasourceFactory $datasourceFactory
     */
    public function setDatasourceFactory(DatasourceFactory $datasourceFactory) {
        $this->datasourceFactory = $datasourceFactory;
    }

    /**
     * @return mixed
     */
    protected function getEntityManager() {
        return $this->container->get('EntityManager');
    }


    /**
     * @param HttpRequest $request
     * @param FilterChain $chain
     * @return void
     */
    public function execute(HttpRequest &$request,  FilterChain &$chain): void {
        $chain->execute($request, $chain);
    }

}