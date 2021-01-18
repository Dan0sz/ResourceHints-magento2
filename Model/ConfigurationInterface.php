<?php

declare(strict_types=1);

namespace Dan0sz\ResourceHints\Model;

interface ConfigurationInterface
{
    const WEB_CONFIG_RESOURCE_HINTS = 'web/resource_hints/config';

    /**
     * Get resource hints
     *
     * @param   null|string|bool|int|Store $store
     * @return  null|string|bool|int
     */
    public function getResourceHints($store = null);
}
