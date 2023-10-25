<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Illarion\CustomerHobby\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class Hobby Options
 */
class HobbyOptions extends AbstractSource
{
    /**
     * Get all options for the "Hobby" attribute.
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => '', 'label' => __('Please select a hobby')],
                ['value' => 'yoga', 'label' => __('Yoga')],
                ['value' => 'traveling', 'label' => __('Traveling')],
                ['value' => 'hiking', 'label' => __('Hiking')],
            ];
        }
        return $this->_options;
    }

    /**
     * Get a text representation of the option value.
     *
     * @param mixed $value
     * @return string
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return '';
    }
}
