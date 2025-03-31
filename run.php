<?php
if ($argv[1] !== "error") {
    error_reporting(0);
}
require "modul/class.php";
Display::Banner_menu();

$pil = isset($argv[2]) ? (int)$argv[2] : (int)getenv('PIL_VALUE');
$pil2 = isset($argv[3]) ? (int)$argv[3] : (int)getenv('PIL2_VALUE');


// Kode menu utama (tidak dijalankan, hanya untuk referensi)
menu_pertama:
Display::Title("Menu");
Display::Line();
$menu = [];
$r = scandir("bot");
$a = 0;
foreach ($r as $act) {
    if ($act == '.' || $act == '..') continue;
    $menu[$a] = $act;
    Display::Menu($a, $act);
    $a++;
}

// Kode menu kedua (tidak dijalankan, hanya untuk referensi)
menu_kedua:
Display::Title("Menu -> " . (isset($menu[$pil]) ? $menu[$pil] : "Tidak Ditemukan"));
Display::Line();
$menu2 = [];
$r = scandir("bot/" . (isset($menu[$pil]) ? $menu[$pil] : ""));
if($r){
    $a = 0;
    foreach ($r as $act) {
        if ($act == '.' || $act == '..') continue;
        $menu2[$a] = $act;
        Display::Menu($a, Functions::clean($act));
        $a++;
    }
    Display::Menu($a, "Back");
}else{
    Display::Error("Folder bot/$menu[$pil] tidak ditemukan!");
}


// Jalankan bot dengan penanganan kesalahan
$botPath = "bot/" . (isset($menu[$pil]) ? $menu[$pil] : "") . "/" . (isset($menu2[$pil2]) ? $menu2[$pil2] : "");
if (file_exists($botPath)) {
    define("title", Functions::clean((isset($menu2[$pil2]) ? $menu2[$pil2] : "")));
    require $botPath;
} else {
    Display::Error("File bot tidak ditemukan: " . $botPath);
}

?>
