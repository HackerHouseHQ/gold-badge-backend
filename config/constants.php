<?php

define('PARAM_ERROR', 418);
define('NOT_EXISTS', 402);
define('FATAL_ERROR', 500);
define('DATA_EXISTS', 411);
define('SUCCESS', 200);
define('YES', 1);

define('NO', 0);


defined("ACTIVE") or define("ACTIVE", 1);

defined("BLOCKED") or define("BLOCKED", 2);
define("PUBLIC", 1);
define("PRIVATE", 0);

defined("DELETED") or define("DELETED", 3);
defined("CURRENT_DATE") or define("CURRENT_DATE", date('Y-m-d H:i:s'));
defined("ITEM_PER_PAGE") or define("ITEM_PER_PAGE", 100);
defined("PER_PAGE_ITEM") or define("PER_PAGE_ITEM", 100);
defined("IS_COMPLETE") or define("IS_COMPLETE", "IS_COMPLETE");
defined("TOTAL") or define("TOTAL", "TOTAL");
defined("ITEMS") or define("ITEMS", "ITEMS");
defined("LIMIT") or define("LIMIT", 5);
defined("VISIBLE") or define("VISIBLE", 1);

defined("INVISIBLE") or define("INVISIBLE", 0);

return [

    'LINKTYPE' => [
        1 => "web",
        2 => "facebook",
        3 => "linked",
        4 => "twitter",
        5 => "instagram"
    ],
    'HIRE' => [
        'REQUESTED' => 1,
        'ONGOING' => 2,
        'CONFIRMED' => 3,
        'CANCELLED' => 4
    ],
];