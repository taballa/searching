<?php 
include './vendor/autoload.php';

$baidu_url = '';
$google_url = '';
$keyword = '';

if ($_GET && $_GET['keyword']){
    $keyword = urlencode($_GET['keyword']);
    $baidu_url = "http://www.baidu.com/baidu?wd=" . $keyword;
    $google_url = "https://www.google.com.hk/search?&q=" . $keyword;
}
?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>Searching</title>
    <style>
    #baidu-frame, #google-frame {
        width: 100%;
        height: 100%;
    }
    .wrapper {
        margin: 0 auto;
    }
    #baidu-content, #google-content {
        width: 50%;
        height: 100%;
        float: left;
    }

    /*for baidu*/
    #u {
        display: none;
    }
    </style>
    <script src="components/jquery/jquery.js"></script>
</head>
<body>
    <div class="search-form">
        <form action="index2.php" method="get">
            <input type="text" name="keyword" value = "<?php echo urldecode($keyword) ?>">
            <input type="submit" value="Search">
        </form>
    </div>
    <div class="wrapper">
        <div id="baidu-content">
            <iframe src="http://www.baidu.com/s?wd=<?php echo "$keyword" ?>" frameborder="0" id="baidu-frame" scrolling="auto"></iframe>
        </div> 
        <div id="google-content">
            <!-- <iframe src="" frameborder="0" scrolling="auto" id="google-frame"> -->
                <script>
                (function() {
                    var cx = '013485985423317541061:2qzqsth3mng';
                    var gcse = document.createElement('script');
                    gcse.type = 'text/javascript';
                    gcse.async = true;
                    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                    '//www.google.com/cse/cse.js?cx=' + cx;
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(gcse, s);
                })();
                </script>
                <gcse:search></gcse:search>
            <!-- </iframe> -->
        </div>
    </div>
    <script>
        var iframe_baidu = document.getElementById("baidu-frame");
        iframe_baidu.height = $(document).height();
    </script>
</body>
</html>