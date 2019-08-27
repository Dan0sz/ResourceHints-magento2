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

    /** @var  $_customerGroupRenderer */
    protected $_customerGroupRenderer;

    /** @var bool $_addAfter */
    protected $_addAfter = true;

    /** @var $_addButtonLabel */
    protected $_addButtonLabel;

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
        if (!$this->_customerGroupRenderer) {
            $this->_customerGroupRenderer = $this->getLayout()->createBlock(
                '\Dan0sz\ResourceHints\Block\Adminhtml\Form\Field\Configure',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->_customerGroupRenderer;
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
        $this->_addAfter       = false;
        $this->_addButtonLabel = __('Add Resource Hint');
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
            $this->_columns[$columnName]['class'] = 'input-text required-entry';
            $this->_columns[$columnName]['style'] = 'width: 150px';
        }

        if ($columnName == 'resource') {
            $this->_columns[$columnName]['class'] = 'input-text required-entry';
            $this->_columns[$columnName]['style'] = 'width: 300px';
        }

        if ($columnName == 'sort_order') {
            $this->_columns[$columnName]['class'] = 'input-text required-entry validate-number';
            $this->_columns[$columnName]['style'] = 'width: 50px';
        }

        return parent::renderCellTemplate($columnName);
    }
}
