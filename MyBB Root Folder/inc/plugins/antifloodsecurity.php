<?php
//Disallow direct Initialization for extra security.

if(!defined("IN_MYBB"))
{
    die("You Cannot Access This File Directly. Please Make Sure IN_MYBB Is Defined.");
}

// Hooks
$plugins->add_hook('global_start', 'antifloodsecurity_global_start');

// Information
function antifloodsecurity_info()
{
return array(
        "name"  => "Anti-DDoS",
        "description"=> "Protect your forum from Floods and Attacks",
        "website"        => "http://community.mybb.com/mods.php",
        "author"        => "Escort",
        "authorsite"    => "http://mybbsupport.ml",
        "version"        => "1.0",
        "guid"             => "6be8b4fc241d78d9b0642009cf5df2ca",
        "compatibility" => "18*"
    );
}

// Activate
function antifloodsecurity_activate() {
global $db;

$antifloodsecurity = array(
        'gid'    => 'NULL',
        'name'  => 'Anti-DDoS',
        'title'      => 'Anti Flood/DoS Security Mybb Plugin',
        'description'    => 'Protect your forum from Floods and Attacks',
        'disporder'    => "1",
        'isdefault'  => "0",
    );
$db->insert_query('settinggroups', $antifloodsecurity_group);
 $gid = $db->insert_id();

$antifloodsecurity_setting = array(
        'sid'            => 'NULL',
        'name'        => 'antifloodsecurity_enable',
        'title'            => 'Do you want to activate Plugin?',
        'description'    => 'Protect your forum from Floods and Attacks.',
        'optionscode'    => 'yesno',
        'value'        => '1',
        'disporder'        => 1,
        'gid'            => intval($gid),
    );
$db->insert_query('settings', $antifloodsecurity_setting);
  rebuild_settings();
}

// Deactivate
function antifloodsecurity_deactivate()
  {
  global $db;
 $db->query("DELETE FROM ".TABLE_PREFIX."settings WHERE name IN ('antifloodsecurity_enable')");
    $db->query("DELETE FROM ".TABLE_PREFIX."settinggroups WHERE name='antifloodsecurity'");
rebuild_settings();
 }

function antifloodsecurity_global_start(){
global $mybb;

if ($mybb->settings['antifloodsecurity_enable'] == 1){
 IF (!ISSET($_SESSION)) {
    SESSION_START();
}
// anti flood protection
IF($_SESSION['last_session_request'] > TIME() - 0.1){
    // users will be redirected to this page if they make requests faster than 3 seconds
    HEADER("location: /403.html");
    EXIT;
}
$_SESSION['last_session_request'] = TIME();
}
} 
?>