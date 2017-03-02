<?php

class Ambimax_YouTube_Block_Video extends Mage_Core_Block_Template
{
    /**
     * Ambimax_YouTube_Block_Video constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setData('title', $this->helper('ambimax_youtube')->__('Videos'));
        return $this;
    }

    /**
     * Returns current product
     *
     * @return Mage_Catalog_Model_Product|mixed
     */
    public function getProduct()
    {
        return Mage::registry('current_product');
    }

    /**
     * Returns iframe width
     *
     * @return mixed
     */
    public function getIframeWidth()
    {
        if($this->hasData('width')) {
            return $this->getData('width');
        }

        return Mage::getStoreConfig('catalog/frontend/iframe_width');
    }

    /**
     * Returns iframe height
     *
     * @return mixed
     */
    public function getIframeHeight()
    {
        if($this->hasData('height')) {
            return $this->getData('height');
        }

        return Mage::getStoreConfig('catalog/frontend/iframe_height');
    }

    /**
     * Returns youtube video id
     *
     * @return string|null
     */
    public function getVideoId()
    {
        return array_values($this->getVideoIds())[0];
    }

    /**
     * Returns youtube video ids
     *
     * @return array
     */
    public function getVideoIds($removeFirstElement = false)
    {
        $videoIds = (array) array_map('trim', (array) explode(',', $this->_getVideoIds()));

        if($removeFirstElement) {
            array_shift($videoIds);
        }
        return $videoIds;
    }

    /**
     * Returns true when multiple videos are used
     *
     * @return bool
     */
    public function isPlaylist()
    {
        return strpos($this->_getVideoIds(), ',') !== false;
    }

    /**
     * Returns full youtube url
     *
     * @return string
     */
    public function getYoutubeUrl()
    {
        $params[] = sprintf('loop=%s', (int) Mage::getStoreConfigFlag('catalog/frontend/loop_videos'));

        if($this->isPlaylist()) {
            return sprintf('https://www.youtube.com/embed/%s?playlist=%s&%s',
                $this->getVideoId(),
                implode(',', $this->getVideoIds(true)),
                implode('&', $params)
            );
        }

        return sprintf('https://www.youtube.com/embed/%s?%s', $this->getVideoId(), implode('&', $params));
    }

    /**
     * Direct access video id(s)
     *
     * @return mixed
     */
    protected function _getVideoIds()
    {
        return $this->getProduct()->getData(Ambimax_YouTube_Helper_Data::ATTRIBUTE_CODE);
    }

    /**
     * Returns empty string when product has no attachments
     *
     * @return string
     */
    protected function _toHtml()
    {
        if( ! Mage::getStoreConfigFlag('catalog/frontend/enable_youtube_video')) {
            return '';
        }

        $youTubeId = $this->getProduct()->getData(Ambimax_YouTube_Helper_Data::ATTRIBUTE_CODE);
        if(empty($youTubeId)) {
            return '';
        }

        $this->setData('title', $this->helper('ambimax_youtube')->__('Videos'));
        return parent::_toHtml();
    }

    /**
     * Retrieve block cache tags
     *
     * @return array
     */
    public function getCacheTags()
    {
        return array_merge(parent::getCacheTags(), $this->getProduct()->getCacheIdTags());
    }

    /**
     * Get block cache life time
     *
     * @return int
     */
    public function getCacheLifetime()
    {
        return 846400;
    }

    /**
     * Get cache key informative items
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array(
            'BLOCK_TPL',
            Mage::app()->getStore()->getCode(),
            $this->getTemplateFile(),
            'template' => $this->getTemplate(),
            $this->getProduct()->getId()
        );
    }
}