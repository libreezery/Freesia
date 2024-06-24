<?php
if (!empty($_GET)) {
    $dir = "../res/file";
    if (!file_exists($dir)) {
        mkdir($dir);
    }
    $s = $_GET['s'];
    switch ($s) {
        case 0:
            // 0:query
            $scandir = scandir($dir);
            foreach ($scandir as $file) {
                $file_link = "res/file/".$file;
                if ($file!="." && $file!="..") {
                    echo <<<HTML
<label>
<a href="$file_link" class="file-link-a" download="$file">$file</a>
&emsp;<a class="file-link-a" onclick="deleteFile('$file')" style="cursor: pointer;">删除</a>
</label>
HTML;
                }
            }
            break;
        case 1:
            if (!empty($_FILES)) {
                $files = $_FILES['files'];
                $name = $files['name'];
                $tmp_name = $files['tmp_name'];
                for ($i = 0; $i < sizeof($name); $i++) {
                    $new_path = "../res/file/" . $name[$i];
                    move_uploaded_file($tmp_name[$i],$new_path);
                }
                echo <<<HTML
<h1>上传成功</h1>
<button onclick="window.location.replace(document.referrer);">返回</button>
HTML;

            }
            break;
        case 2:
            $data = $_GET['data'];
            $link = "../res/file/".$data;
            if (file_exists($link)) {
                unlink($link);
            }
            echo "ok";
            break;
        case 3:
            // 3:clear
            $scandir = scandir($dir);
            foreach ($scandir as $file) {
                if ($file!="." && $file!="..") {
                    $unlink_path = "../res/file/".$file;
                    unlink($unlink_path);
                }
            }
            echo "ok";
            break;
    }
}