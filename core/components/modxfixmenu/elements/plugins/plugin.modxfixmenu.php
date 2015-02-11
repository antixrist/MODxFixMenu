<?php

switch ($modx->event->name) {
  case 'OnManagerPageBeforeRender':
    $byClick          = $modx->getOption('modxfixmenu.open_by_click', null, 1);
    $transition       = $modx->getOption('modxfixmenu.transition', null, 0);
    $timeout          = $modx->getOption('modxfixmenu.autoclose_timeout', null, 0.5);
    $className        = $modx->getOption('modxfixmenu.css_classname', null, 'opened');

    $transition = str_replace(',', '.', $transition);
    $transition = preg_replace('/[^\d\.]/im', '', $transition);

    $timeout = str_replace(',', '.', $timeout);
    $timeout = preg_replace('/[^\d\.]/im', '', $timeout);
    $timeout = $timeout * 1000;

    $transitionString = (!$transition) ? 'none' : "all ${transition}s ease ${transition}s";
    $transitionString = <<<TRANSITION
  -webkit-transition: $transitionString;
  -moz-transition: $transitionString;
  transition: $transitionString;
TRANSITION;
    $closeCss = <<<CLOSECSS
  /*display: none;*/
  opacity: 0;
  visibility: hidden;
CLOSECSS;
    $openCss = <<<OPENCSS
  -webkit-transition: $transitionString;
  -moz-transition: $transitionString;
  transition: $transitionString;
  display: block;
  opacity: 1;
  visibility: visible;
OPENCSS;

    if (!$byClick) {
      $css = <<<CSS

#modx-navbar li:hover ul.modx-subnav,
#modx-navbar ul.modx-subnav li:hover ul,
#modx-navbar ul.modx-subnav ul li:hover ul,
#modx-navbar ul.modx-subnav ul ul li:hover ul,
#modx-navbar ul.modx-subnav ul ul ul li:hover ul {
$openCss
$transitionString
}

CSS;
    } else if ($className) {
      $css = <<<CSS
#modx-navbar ul ul {
$transitionString
}

#modx-navbar li:hover ul.modx-subnav,
#modx-navbar ul.modx-subnav li:hover ul,
#modx-navbar ul.modx-subnav ul li:hover ul,
#modx-navbar ul.modx-subnav ul ul li:hover ul,
#modx-navbar ul.modx-subnav ul ul ul li:hover ul {
$closeCss
}

#modx-navbar li.{$className} ul.modx-subnav,
#modx-navbar ul.modx-subnav li.{$className} ul,
#modx-navbar ul.modx-subnav ul li.{$className} ul,
#modx-navbar ul.modx-subnav ul ul li.{$className} ul,
#modx-navbar ul.modx-subnav ul ul ul li.{$className} ul {
$openCss
$transitionString
}

CSS;
    }

    $css .= <<<CSS

#modx-navbar .top {
  padding-right: 0;
}
#modx-navbar a {
  padding: 0 30px 0 15px;
}

#modx-navbar a {
  cursor: pointer;
}
#modx-navbar .top > a,
#modx-navbar a:not([href]) {
  cursor:default;
}

CSS;
    $css = '<style>'. $css .'</style>';
    $modx->controller->addHtml($css);

    $corePath = $modx->getOption('mfm.core_path', null, $modx->getOption('core_path').'components/modxfixmenu/');
    $assetsUrl = $modx->getOption('mfm.assets_url', null, $modx->getOption('assets_url').'components/modxfixmenu/');


    if ($byClick && $className) {
      $js = <<<SCRIPT
<script>
  MODxFixMenuConfig = {
    timeout: $timeout,
    className: '{$className}'
  };
</script>
SCRIPT;
      $modx->controller->addHtml($js);

      $assetsUrl = $modx->getOption('modxfixmenu.assets_url', null, $modx->getOption('assets_url').'components/modxfixmenu/', true);
      $modx->controller->addLastJavascript($assetsUrl .'js/mgr/modxfixmenu.js');
    }
    break;
}