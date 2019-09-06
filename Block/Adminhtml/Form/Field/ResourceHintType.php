<?php
/**
 * @author   : Daan van den Bergh
 * @url      : https://daan.dev
 * @package  : Dan0sz/ResourceHints
 * @copyright: (c) 2019 Daan van den Bergh
 */

namespace Dan0sz\ResourceHints\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;

class ResourceHintType extends Select
{
    /** @var array $_options */
    protected $_options = [
        'preload'      => 'Preload',
        'preconnect'   => 'Preconnect',
        'dns-prefetch' => 'DNS Prefetch'
    ];

    /**
     * ResourceHintType constructor.
     *
     * @param Context $context
     * @param array   $data
     */
    public function __construct(
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            foreach ($this->_options as $value => $label) {
                $this->addOption($value, $label);
            }
        }

        $this->setClass('input-select required-entry');
        $this->setExtraParams('style="width: 125px;"');

        return parent::_toHtml();
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }
}
