<?php

declare(strict_types=1);

namespace Dan0sz\ResourceHints\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Configuration implements ConfigurationInterface
{
    /** @var ScopeConfigInterface $scopeConfig */
    protected $scopeConfig;

    /** @var Mixed $resourceHints */
    private $resourceHints;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function getResourceHints($store = null)
    {
        if (null !== $this->resourceHints) {
            return $this->resourceHints;
        }
        return $this->scopeConfig->getValue(
            self::WEB_CONFIG_RESOURCE_HINTS,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
