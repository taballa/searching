<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>google + baidu</title>
    <style>
    #baidu, #google {
        width: 50%;
        float: left;
        overflow: hidden;
    }
    #navigation {
        z-index: 999;
        position: absolute;
    } 
    #result {
        margin-top: 25px;
    }
    /*for baidu*/
    

    /* for google*/
    #gb {
        display: none;
    }
    </style>
</head>
<?php 
// header("Content-Type: text/html;charset=UTF-8");
$baidu_content = '';
$google_content = '';
$keyword = '';

if ($_GET['keyword']){
    $keyword = urlencode($_GET['keyword']);
    $baidu_url = "http://www.baidu.com/baidu?wd=" . $keyword;
    $google_url = "http://www.google.com/search?&q=" . $keyword;

// fetch baidu
// $baidu_content = file_get_contents($baidu_url);
    $ch = curl_init();
    $cookie_file = dirname(__FILE__).'/cookie.txt';
    curl_setopt($ch, CURLOPT_URL, $baidu_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file); 
    $baidu_content = curl_exec($ch);
    curl_close($ch);

// fetch google
    $ch = curl_init();
    // $this_header = array(
    //     "content-type: application/x-www-form-urlencoded; 
    //     charset=UTF-8"
    //     );
    // curl_setopt($ch,CURLOPT_HTTPHEADER,$this_header);
    $cookie_file = dirname(__FILE__).'/cookie.txt';
    curl_setopt($ch, CURLOPT_URL, $google_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    // curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $google_content = curl_exec($ch);
    $google_content = iconv('GBK', 'utf-8', $google_content);
    curl_close($ch);
}
?>
<body>
    <div id="navigation">
        <form action="index.php" method="get">
            <input type="text" name="keyword" value = "<?php echo urldecode($keyword) ?>">
            <input type="submit" value="Search">
        </form>
    </div>
    <div id="result">
        <div id="baidu">
            <?php 
            echo "$baidu_content";
            ?>
        </div>
        <div id="google">
            <?php 
            echo "$google_content";
            ?>
        </div>
    </div>
</body>
</html>