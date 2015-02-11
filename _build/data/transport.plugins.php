<?php

$plugins = array();

$tmp = array(
	'MODxFixMenu' => array(
		'file' => 'modxfixmenu',
		'description' => '',
		'events' => array(
			'OnManagerPageBeforeRender' => array()
		)
	)
);

foreach ($tmp as $k => $v) {
  $pluginPath = (PKG_DEV)
    ? MODX_BASE_PATH . PKG_NAME .'/core/components/'. PKG_NAME_LOWER .'/elements/plugins/plugin.'. $v['file'] .'.php'
    : 'core/components/'. PKG_NAME_LOWER .'/elements/plugins/plugin.'. $v['file'] .'.php';

  /* @var modplugin $plugin */
	$plugin = $modx->newObject('modPlugin');
	$plugin->fromArray(array(
		'name' => $k,
		'category' => 0,
		'description' => @$v['description'],
		'plugincode' => getSnippetContent($sources['source_core'] . '/elements/plugins/plugin.' . $v['file'] . '.php'),
		'static' => BUILD_PLUGIN_STATIC,
		'source' => 1,
		'static_file' => $pluginPath
	), '', true, true);

  if (BUILD_PLUGIN_STATIC) {
    $plugin->set('source', 0);
    $plugin->set('static_file', $pluginPath);
  }

  $events = array();
	if (!empty($v['events'])) {
		foreach ($v['events'] as $k2 => $v2) {
			/* @var modPluginEvent $event */
			$event = $modx->newObject('modPluginEvent');
			$event->fromArray(array_merge(
				array(
					'event' => $k2,
					'priority' => 0,
					'propertyset' => 0,
				), $v2
			), '', true, true);
			$events[] = $event;
		}
		unset($v['events']);
	}

	if (!empty($events)) {
		$plugin->addMany($events);
	}

	$plugins[] = $plugin;
}

unset($tmp, $properties);
return $plugins;