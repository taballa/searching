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
    .search-form {
      margin: 0 auto;
      width: 550px;
    }
    .search-form .text {
      width: 350px;
      height: 30px;
    }
    .search-form .submit {
      /*width: 25px;*/
    }

    /*for baidu*/
    #u {
        display: none;
    }
    .fm {
        display: none;
    }
    </style>
    <link rel='stylesheet' href='http://www.google.com/cse/style/look/default.css' type='text/css'/>
    <script src="components/jquery/jquery.js"></script>
</head>
<body>
    <div class="search-form">
        <form action="index2.php" method="get">
            <input type="text" name="keyword" value = "<?php echo urldecode($keyword) ?>" class="text">
            <input type="submit" value="Search" class="submit">
        </form>
    </div>
    <div class="wrapper">
        <div id="baidu-content">
            <iframe src="http://www.baidu.com/s?wd=<?php echo "$keyword" ?>" frameborder="0" id="baidu-frame" scrolling="auto"></iframe>
        </div> 
        <div id="google-content">
            <!-- <iframe src="" frameborder="0" scrolling="auto" id="google-frame"> -->
    <div id='cse' style='width: 100%;'>Loading</div>
    <script src='//www.google.com/jsapi' type='text/javascript'></script>
    <script type='text/javascript'>
    google.load('search', '1', {language: 'zh-Hans', style: google.loader.themes.DEFAULT});
    google.setOnLoadCallback(function() {
      var customSearchOptions = {};
      var orderByOptions = {};
      orderByOptions['keys'] = [{label: 'Relevance', key: ''} , {label: 'Date', key: 'date'}];
      customSearchOptions['enableOrderBy'] = true;
      customSearchOptions['orderByOptions'] = orderByOptions;
      var imageSearchOptions = {};
      imageSearchOptions['layout'] = 'google.search.ImageSearch.LAYOUT_POPUP';
      customSearchOptions['enableImageSearch'] = true;
      customSearchOptions['adoptions'] = {'layout' : 'noTop'};
      var customSearchControl =   new google.search.CustomSearchControl('013485985423317541061:2qzqsth3mng', customSearchOptions);
      customSearchControl.setResultSetSize(google.search.Search.LARGE_RESULTSET);
      var options = new google.search.DrawOptions();
      customSearchControl.draw('cse', options);
      customSearchControl.execute("<?php echo $keyword ?>");
    }, true);
    </script>
            <!-- </iframe> -->
        </div>
    </div>
    <script>
        // var iframe_baidu = document.getElementById("baidu-frame");
        // iframe_baidu.height = $(document).height();
    </script>
</body>
</html>