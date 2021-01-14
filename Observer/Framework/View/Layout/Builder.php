<?php
/**
 * @author   : Daan van den Bergh
 * @url      : https://daan.dev
 * @package  : Dan0sz/ResourceHints
 * @copyright: (c) 2020 Daan van den Bergh
 */

namespace Dan0sz\ResourceHints\Observer\Framework\View\Layout;

use Dan0sz\ResourceHints\Model\PrepareResources;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Page\Config;

class Builder implements ObserverInterface
{
    /** @var PrepareResources $resources */
    private $resources;

    /** @var Config $pageConfig */
    private $pageConfig;

    /**
     * Builder constructor.
     *
     * @param PrepareResources $configurationInterface
     * @param Config  $pageConfig
     */
    public function __construct(
        PrepareResources $prepareResources,
        Config $pageConfig
    ) {
        $this->resources = $prepareResources;
        $this->pageConfig  = $pageConfig;
    }

    /**
     * Execute
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        // Get resource hints
        $resourceHints = $this->resources->getCollection();
        // Sort resource hints
        $resourceHints->setOrder('sort');
        // Loop over resource hints
        foreach ($resourceHints as $resource) {
            $href = $resource->getHref();
            $properties = $resource->getProperties();
            // Add resource hint to page
            $this->pageConfig->addRemotePageAsset($href, 'link_rel', $properties);
        }
        return $this;
    }
}
