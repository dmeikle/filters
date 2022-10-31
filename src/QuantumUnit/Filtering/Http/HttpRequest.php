<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 3/1/2017
 * Time: 8:18 PM
 */

namespace QuantumUnit\Filtering\Http;


/**
 * HttpRequest
 *
 * @author Organization: Quantum Unit
 * @author Developer: David Meikle <david@quantumunit.com>
 */
class HttpRequest extends Request
{

    protected $requestParams;

    protected $nodeConfig;

    /**
     * @param RequestParams $requestParams
     * @param SiteParams $siteParams
     */
    public function __construct(RequestParams $requestParams, SiteParams $siteParams) {
        $this->requestParams = $requestParams;
        $this->siteParams = $siteParams;
    }

    /**
     * @return string
     */
    public function getMethod(): string {
        return $this->requestParams->getMethod();
    }

    /**
     * @return string
     */
    public function getYmlKey(): string {
        return $this->requestParams->getYmlKey();
    }

    /**
     * @return SiteParams
     */
    public function getSiteParams(): SiteParams {
        return $this->siteParams;
    }

    /**
     * @return RequestParams
     */
    public function getRequestParams(): RequestParams {
        return $this->requestParams;
    }

    /**
     * @param RequestParams $requestParams
     * @return void
     */
    public function setRequestParams(RequestParams $requestParams): void {
        $this->requestParams = $requestParams;
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function setPostParameter($key, $value): void {
        $this->requestParams->setPostParameter($key, $value);
    }

    /**
     * @return array
     */
    public function getNodeConfig(): array {
        return $this->nodeConfig;
    }

    /**
     * @param mixed $nodeConfig
     * @return HttpRequest
     */
    public function setNodeConfig(&$nodeConfig) {

        if(array_key_exists('ymlKey', $nodeConfig)) {
            $this->requestParams->setYmlKey($nodeConfig['ymlKey']);
        }else{
            $key = (key($nodeConfig));
            $nodeConfig['ymlKey'] = $key;
            $this->requestParams->setYmlKey($key);
        }
                
        $this->nodeConfig = $nodeConfig;

        return $this;
    }
}