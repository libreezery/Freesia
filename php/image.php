<?php
if (!empty($_GET)) {
    $dir = "../res/img";
    if (!file_exists($dir)) {
        mkdir($dir);
    }
    $s = $_GET['s'];
    switch ($s) {
        case 0:
            // 0:query
            $scandir = scandir($dir);
            $path = "res/img/";
            foreach ($scandir as $file) {
                if ($file == "." || $file == "..") {
                    continue;
                }
                $img_path = $path.$file;
                echo <<<HTML
<a href="$img_path" target="_blank">
<img src="${img_path}" alt="$file" style="width: 70px;margin-right: 10px;margin-top: 10px"/>
</a>
HTML;
            }
            break;
        case 1:
            // 1:add
            if (!empty($_FILES)) {
                $files = $_FILES['files'];
                $name = $files['name'];
                $tmp_name = $files['tmp_name'];
                for ($i = 0; $i < sizeof($name); $i++) {
                    $new_path = "../res/img/" . $name[$i];
                    move_uploaded_file($tmp_name[$i],$new_path);
                }
                echo <<<HTML
<h1>上传成功</h1>
<button onclick="window.location.replace(document.referrer);">返回</button>
HTML;

            }
            break;
        case 2:
            // 2:single query
            break;
        case 3:
            // 3:clear
            $scandir = scandir($dir);
            foreach ($scandir as $file) {
                if ($file!="." && $file!="..") {
                    $unlink_path = "../res/img/".$file;
                    unlink($unlink_path);
                }
            }
            echo "ok";
            break;
    }
}