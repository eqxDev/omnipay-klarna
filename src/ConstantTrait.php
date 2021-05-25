<?php

namespace Omnipay\Klarna;

trait ConstantTrait
{
    public $api_version_europe        = 'EU';
    public $api_version_north_america = 'NA';
    public $api_version_oceania       = 'OC';

    //Europe URL
    public $eu_base_url      = 'https://api.klarna.com';
    public $eu_test_base_url = 'https://api.playground.klarna.com';

    //North America URL
    public $na_base_url       = 'https://api-na.klarna.com';
    public $na_test_base_url  = 'https://api-na.playground.klarna.com';

    //Ocenia URL
    public $oc_base_url       = 'https://api-oc.klarna.com';
    public $oc_test_base_url  = 'https://api-oc.playground.klarna.com';

    /**
     * @return string
     */
    public function getApiRegion(): string
    {
        return $this->getParameter('apiRegion');
    }

    /**
     * @param string $value
     */
    public function setApiRegion(string $region)
    {
        return $this->setParameter('apiRegion', $region);
    }
}
