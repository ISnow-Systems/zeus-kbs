<?php
const DS = DIRECTORY_SEPARATOR;
const ZEUS_ROOT_DIR = __DIR__;
const ZEUS_APPLICATION = ZEUS_ROOT_DIR . DS . "appli";
const ZEUS_CONTENTS_ROOT = ZEUS_ROOT_DIR . DS . "page-data";
const ZEUS_STORAGE = ZEUS_CONTENTS_ROOT . DS . "storage";
const ZEUS_PAGES = ZEUS_CONTENTS_ROOT . DS . "pages";
const ZEUS_WWW_ROOT = ZEUS_ROOT_DIR . DS . "www-root";
const ZEUS_LAYOUTS = ZEUS_ROOT_DIR . DS . "layouts";
const ZEUS_STATIC = ZEUS_ROOT_DIR . DS . "static";
const ZEUS_CACHE = ZEUS_ROOT_DIR . DS . "cache";

require_once ZEUS_ROOT_DIR . DS . "config.php";
require_once ZEUS_APPLICATION . DS . "parsedown.php";
require_once ZEUS_APPLICATION . DS . "routes.php";

const ZEUS_VERSION_CODE = 1;
const ZEUS_VERSION_VALUE_INTERNAL = "0.99.001";
const ZEUS_VERSION_VALUE_PUB = "1.0";
const ZEUS_VERSION_COMPLEX = "Zeus/" . ZEUS_VERSION_VALUE_PUB;
const ZEUS_VERSION_COMPLEX_SITE_NAME = ZEUS_SITE_NAME . "(Zeus/" . ZEUS_VERSION_VALUE_PUB . ")";