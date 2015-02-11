<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* define package */
define('PKG_NAME', 'MODxFixMenu');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));

define('PKG_VERSION', '0.0.1');
define('PKG_RELEASE', 'beta');
define('PKG_AUTO_INSTALL', true);
define('PKG_DEV', true);

define('MODX_BASE_URL', '/');
define('MODX_BASE_PATH', dirname(dirname(dirname(__FILE__))) . '/');

define('MODX_ASSETS_PATH', MODX_BASE_PATH . 'assets/');
define('MODX_ASSETS_URL', MODX_BASE_URL . 'assets/');

if (PKG_DEV) {
  define('PKG_NAMESPACE_PATH', '{base_path}'. PKG_NAME .'/core/components/'. PKG_NAME_LOWER .'/');
  define('PKG_NAMESPACE_ASSETS_PATH', '{base_path}'. PKG_NAME .'/assets/components/'. PKG_NAME_LOWER .'/');

  define('MODX_CORE_PATH', dirname(MODX_BASE_PATH) . '/core/');

  define('MODX_MANAGER_PATH', MODX_BASE_PATH . 'adminka/');
  define('MODX_MANAGER_URL', MODX_BASE_URL . 'adminka/');

//  define('MODX_CONNECTORS_PATH', MODX_BASE_PATH . 'connectors-7rXt-B1s/');
//  define('MODX_CONNECTORS_URL', MODX_BASE_URL . 'connectors-7rXt-B1s/');
} else {
  define('PKG_NAMESPACE_PATH', '{core_path}components/'. PKG_NAME_LOWER .'/');
  define('PKG_NAMESPACE_ASSETS_PATH', '{assets_path}components/'. PKG_NAME_LOWER .'/');

  define('MODX_CORE_PATH', MODX_BASE_PATH . 'core/');

  define('MODX_MANAGER_PATH', MODX_BASE_PATH . 'manager/');
  define('MODX_MANAGER_URL', MODX_BASE_URL . 'manager/');

//  define('MODX_CONNECTORS_PATH', MODX_BASE_PATH . 'connectors/');
//  define('MODX_CONNECTORS_URL', MODX_BASE_URL . 'connectors/');
}

define('BUILD_SETTING_UPDATE', true);
define('BUILD_PLUGIN_UPDATE', true);

define('BUILD_PLUGIN_STATIC', PKG_DEV);
