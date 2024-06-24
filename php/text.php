<?php
if (!empty($_GET)) {
    $file = "../res/text.txt";
    if (!file_exists($file)) {
        fopen($file, "w");
    }
    $s = $_GET['s'];
    if ($s == 0) {
        // 0: query
        $file1 = file($file);
        $file1 = array_reverse($file1);
        foreach ($file1 as $line) {
            $json_decode = json_decode($line, true);
            $time = $json_decode['time'];
            $data = $json_decode['data'];
            $length = $json_decode['length'];
            $time_format = date("H:i:s", $time);
            $show_data = $data;
            if ($length>15) {
                $show_data=mb_substr($data,0,15);
            }
            echo <<<HTML
<li class="li-text-save"><label>$time_format:</label><a href="php/text.php?s=2&time=${time}">$show_data...</a> </li>
HTML;

        }
    } else if ($s == 1) {
        // 1：add
        if (!empty($_POST)) {
            $data = $_POST['data'];
            $text_array = array("time" => time(),
                "data" => $data,
                "length" => mb_strlen($data));
            $json_encode = json_encode($text_array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            file_put_contents($file, $json_encode . "\n", FILE_APPEND);
            echo "ok";
        }
    } else if ($s == 2) {
        // 2：single query
        $time1 = $_GET['time'];
        $file1 = file($file);
        foreach ($file1 as $line) {
            $json_decode = json_decode($line, true);
            $time2 = $json_decode['time'];
            if (strcmp($time1,$time2)==0) {
                echo $json_decode['data'];
            }
        }
    } else if ($s == 3) {
        file_put_contents($file,"");
        echo "ok";
    }
}