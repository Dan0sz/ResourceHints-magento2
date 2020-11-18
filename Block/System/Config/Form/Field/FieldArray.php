<?php
/**
 * @author   : Daan van den Bergh
 * @url      : https://daan.dev
 * @package  : Dan0sz/ResourceHints
 * @copyright: (c) 2019 Daan van den Bergh
 */

namespace Dan0sz\ResourceHints\Block\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class FieldArray extends AbstractFieldArray
{
    /** @var array $_columns */
    protected $_columns = [];

    /** @var bool $_addAfter */
    protected $_addAfter = true;

    /** @var $_addButtonLabel */
    protected $_addButtonLabel;

    /** @var $resourceTypeRenderer */
    private $resourceTypeRenderer;

    /** @var $preloadTypeRenderer */
    private $preloadTypeRenderer;

    /** @var $crossOriginSupportRenderer */
    private $crossOriginSupportRenderer;

    /**
     * FieldArray Constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_addButtonLabel = __('Add Resource Hint');
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function listResourceHintTypes()
    {
        if (!$this->resourceTypeRenderer) {
            $this->resourceTypeRenderer = $this->getLayout()->createBlock(
                '\Dan0sz\ResourceHints\Block\Adminhtml\Form\Field\ResourceHintType',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->resourceTypeRenderer;
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function listPreloadTypes()
    {
        if (!$this->preloadTypeRenderer) {
            $this->preloadTypeRenderer = $this->getLayout()->createBlock(
                '\Dan0sz\ResourceHints\Block\Adminhtml\Form\Field\PreloadType',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->preloadTypeRenderer;
    }

    /**
     * @return string
     */
    private function renderCrossOriginSupport()
    {
        if (!$this->crossOriginSupportRenderer) {
            $this->crossOriginSupportRenderer = $this->getLayout()->createBlock(
                '\Dan0sz\ResourceHints\Block\Adminhtml\Form\Field\CrossOriginSupport',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->crossOriginSupportRenderer;
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'type',
            [
                'label'    => __('Type'),
                'renderer' => $this->listResourceHintTypes(),
            ]
        );
        $this->addColumn(
            'resource',
            [
                'label' => __('Resource')
            ]
        );
        $this->addColumn(
            'sort_order',
            [
                'label' => __('Sort Order')
            ]
        );
        $this->addColumn(
            'preload_as',
            [
                'label' => __('Preload as'),
                'renderer' => $this->listPreloadTypes()
            ]
        );
        $this->addColumn(
            'cross_origin',
            [
                'label' => __('Enable CORS Support'),
                'renderer' => $this->renderCrossOriginSupport()
            ]
        );
        $this->_addAfter       = false;
    }

    /**
     * @param \Magento\Framework\DataObject $row
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $type    = $row->getType();
        $options = [];

        if ($type) {
            $options['option_' . $this->listResourceHintTypes()->calcOptionHash($type)] = 'selected="selected"';
        }

        $preloadAs = $row->getPreloadAs();

        if ($preloadAs) {
            $options['option_' . $this->listPreloadTypes()->calcOptionHash($preloadAs)] = 'selected="selected"';
        }

        $crossOriginSupport = $row->getCrossOrigin();

        if ($crossOriginSupport) {
            $options['option_' . $this->renderCrossOriginSupport()->calcOptionHash($crossOriginSupport)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @param string $columnName
     *
     * @return string
     * @throws \Exception
     */
    public function renderCellTemplate($columnName)
    {
        if ($columnName == "type") {
            $this->_columns[$columnName]['class'] = 'input-select required-entry';
        }

        if ($columnName == 'resource') {
            $this->_columns[$columnName]['class'] = 'input-text required-entry';
            $this->_columns[$columnName]['style'] = 'width: 200px';
        }

        if ($columnName == 'sort_order') {
            $this->_columns[$columnName]['class'] = 'input-text required-entry validate-number';
            $this->_columns[$columnName]['style'] = 'width: 50px';
        }

        if ($columnName == "preload_as") {
            $this->_columns[$columnName]['class'] = 'input-select';
        }

        if ($columnName == 'cross_origin') {
            $this->_columns[$columnName]['class'] = 'input-select';
        }

        return parent::renderCellTemplate($columnName);
    }
}
