<?php

$settings = array();

$tmp = array(
	'open_by_click' => array(
		'xtype' => 'combo-boolean',
		'value' => true,
		'area' => 'modxfixmenu_main',
	),
  'transition' => array(
		'value' => '0',
		'xtype' => 'textfield',
		'area' => 'modxfixmenu_main',
	),
  'autoclose_timeout' => array(
		'value' => '0.5',
		'xtype' => 'textfield',
		'area' => 'modxfixmenu_main',
	),
  'css_classname' => array(
		'value' => 'opened',
		'xtype' => 'textfield',
		'area' => 'modxfixmenu_main',
	),
);

$tmp['assets_path'] = array(
  'xtype' => 'text',
  'value' => '',
  'area' => 'modxfixmenu_pathes',
);
$tmp['assets_url'] = array(
  'xtype' => 'text',
  'value' => '',
  'area' => 'modxfixmenu_pathes',
);
$tmp['core_path'] = array(
  'xtype' => 'text',
  'value' => '',
  'area' => 'modxfixmenu_pathes',
);


if (PKG_DEV) {
  $tmp['assets_path']['value'] = '{base_path}'. PKG_NAME .'/assets/components/'. PKG_NAME_LOWER .'/';
  $tmp['assets_url']['value'] = '{base_url}'. PKG_NAME .'/assets/components/'. PKG_NAME_LOWER .'/';
  $tmp['core_path']['value'] = '{base_path}'. PKG_NAME .'/core/components/'. PKG_NAME_LOWER .'/';
}


foreach ($tmp as $k => $v) {
	/* @var modSystemSetting $setting */
	$setting = $modx->newObject('modSystemSetting');
	$setting->fromArray(array_merge(
		array(
			'key' => PKG_NAME_LOWER .'.' . $k,
			'namespace' => PKG_NAME_LOWER,
		), $v
	), '', true, true);

	$settings[] = $setting;
}

unset($tmp);
return $settings;
