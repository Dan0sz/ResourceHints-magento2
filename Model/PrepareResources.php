<?php

declare(strict_types=1);

namespace Dan0sz\ResourceHints\Model;

use Magento\Framework\Data\CollectionFactory;
use Magento\Framework\Data\Collection;
use Magento\Framework\DataObjectFactory;
use Magento\Framework\DataObject;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\JsonValidator;
use Magento\Framework\View\Asset\Repository;

class PrepareResources
{
    /** @var ConfigurationInterface $configuration */
    private $configuration;

    /** @var CollectionFactory $collectionFactory */
    private $collectionFactory;

    /** @var DataObjectFactory $dataObjectFactory */
    private $dataObjectFactory;

    /** @var Json $json */
    private $json;

    /** @var JsonValidator $jsonValidator */
    private $jsonValidator;

    /** @var Repository $assetRepository */
    private $assetRepository;

    public function __construct(
        ConfigurationInterface $configuration,
        CollectionFactory $collectionFactory,
        DataObjectFactory $dataObjectFactory,
        Json $json,
        JsonValidator $jsonValidator,
        Repository $assetRepository
    ) {
       $this->configuration = $configuration;
       $this->collectionFactory = $collectionFactory;
       $this->dataObjectFactory = $dataObjectFactory;
       $this->json = $json;
       $this->jsonValidator = $jsonValidator;
       $this->assetRepository = $assetRepository;
    }

    /**
     * Get collection
     *
     * @return mixed
     */
    public function getCollection()
    {
        $resources = $this->getResourceHintsFromConfig();
        return $this->getResourceHintsCollection($resources);
    }

    /**
     * Get config
     *
     * @return null|string|bool|int
     */
    private function getResourceHintsFromConfig()
    {
       return $this->configuration->getResourceHints();
    }

    /**
     * Get collection
     *
     * @param null|string|bool|int $resourcesJson
     * @return Collection
     */
    private function getResourceHintsCollection($resourcesJson)
    {
        // Create empty collection
        $collection = $this->collectionFactory->create();
        // Guard against no resources
        $isValid = $this->jsonValidator->isValid($resourcesJson);
        if (!$isValid) return $collection;
        // Parse resource hints json
        $resourceHintsConfig = $this->json->unserialize($resourcesJson);
        // Loop over resource hints
        foreach ($resourceHintsConfig as $resource) {
            // Parse resource config
            $parsedResource = $this->parseResource($resource);
            // Add resource to collection
            $collection->addItem($parsedResource);
        }
        // Return collection
        return $collection;
    }

    /**
     * Parse resource
     *
     * @param array $resource
     * @return DataObject
     */
    private function parseResource($resource)
    {
        $resourceHint = $this->dataObjectFactory->create();
        // Parse resource config
        $href = $this->parseHref($resource['resource']);
        $properties = $this->parseResourceProperties($resource);
        // Set parsed config
        $resourceHint->setData('href', $href);
        $resourceHint->setData('properties', $properties);
        // Return parsed config
        return $resourceHint;
    }

    /**
     * Parse resource attributes
     *
     * @param array $resource
     * @return DataObject
     */
    private function parseResourceAttributes($resource)
    {
        $attributes = $this->dataObjectFactory->create();
        // Set rel to type
        $attributes->setData('rel', $resource['type']);
        // For preload
        if ($resource['type'] === 'preload') {
            // Set asset type
            $attributes->setData('as', $resource['preload_as']);
        }
        // For crossorigin
        if ($resource['cross_origin'] == '1') {
            // Set anonymous
            $attributes->setData('crossorigin', 'anonymous');
        }
        return $attributes;
    }

    /**
     * Parse resource properties
     *
     * @param array $resource
     * @return array
     */
    private function parseResourceProperties($resource)
    {
        $attributes = $this->parseResourceAttributes($resource);
        return ['attributes' => $attributes->toArray()];
    }

    /**
     * Parse resource href
     *
     * @param array $resource
     * @return string
     */
    private function parseHref($href)
    {
        // Check not remote
        return !$this->isRemoteAsset($href)
            // Resolve local url
            ? $this->assetRepository->getUrl($href)
            // No need to resolve, use as is
            : $href;
    }

    /**
     * Check is local asset
     *
     * @param string $asset
     * @return int
     */
    private function isRemoteAsset($asset)
    {
        // Regex for 'http://' or 'https://'or '//'
        $re = '/^https?:\/\/.+|^\/\/.+/';
        // Return number of matches
        return preg_match($re, $asset);
    }
}
