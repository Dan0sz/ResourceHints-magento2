<?php
/**
 * @author   : Daan van den Bergh
 * @url      : https://daan.dev
 * @package  : Dan0sz/ResourceHints
 * @copyright: (c) 2020 Daan van den Bergh
 */

namespace Dan0sz\ResourceHints\Observer\Framework\View\Layout;

use Magento\Framework\App\Config\ScopeConfigInterface as ScopeConfig;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config as PageConfig;

class Builder implements ObserverInterface
{
    const WEB_CONFIG_RESOURCE_HINTS = 'web/resource_hints/config';

    /** @var ScopeConfig $scopeConfig */
    private $scopeConfig;

    /** @var PageConfig $pageConfig */
    private $pageConfig;

    /**
     * Builder constructor.
     *
     * @param ScopeConfig $scopeConfig
     * @param PageConfig  $pageConfig
     */
    public function __construct(
        ScopeConfig $scopeConfig,
        PageConfig $pageConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->pageConfig  = $pageConfig;
    }

    /**
     * @param Observer $observer
     *
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $configArray = $this->scopeConfig->getValue(self::WEB_CONFIG_RESOURCE_HINTS, ScopeConfig::SCOPE_TYPE_DEFAULT);

        if (!$configArray) {
            return $this;
        }

        $resourceHints = $this->sort((array) json_decode($configArray));

        foreach ($resourceHints as $resource) {
            $attributes = [];
            $attributes['rel'] = $resource->type;

            if ($resource->type == 'preload') {
                $attributes['as'] = $resource->preload_as;
            }

            if ($resource->cross_origin == '1') {
                $attributes['crossorigin'] = 'anonymous';
            }

            $this->pageConfig->addRemotePageAsset(
                $resource->resource,
                'link_rel',
                [
                    'attributes' => $attributes
                ]
            );
        }

        return $this;
    }

    private function sort(array $resourceHints)
    {
        usort($resourceHints, function ($first, $second) {
            return $first->sort_order <=> $second->sort_order;
        });

        return $resourceHints;
    }
}