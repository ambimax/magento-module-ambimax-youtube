<?php

/** @var Delphin_Stock_Model_Resource_Setup $installer */
$installer = $this;


$installer->startSetup();

$installer->addAttribute(
    'catalog_product',
    Ambimax_YouTube_Helper_Data::ATTRIBUTE_CODE,
    array(
        'group'                      => 'General',
        'label'                      => 'YouTube ID',
        'note'                       => 'Use comma-separated list to create a playlist',
        'type'                       => 'text',
        'input'                      => 'text',
        'frontend'                   => '',
        'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible'                    => 1,
        'required'                   => 0,
        'user_defined'               => 0,
        'searchable'                 => 0,
        'filterable'                 => 0,
        'comparable'                 => 0,
        'visible_on_front'           => 0,
        'visible_in_advanced_search' => 0,
        'used_in_product_listing'    => 0,
        'unique'                     => 0
    )
);

$installer->endSetup();
