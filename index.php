<?php 
include './vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

$baidu_url = '';
$google_url = '';
$baidu_content = 'Nothing';
$google_content = 'Nothing';
$keyword = '';
$page_number = 10;


if ($_GET && $_GET['keyword']){
    $keyword_origin = $_GET['keyword'];
    $keyword = urlencode($keyword_origin);
    $baidu_url = "http://www.baidu.com/baidu?wd=" . $keyword;
    $google_url = "http://www.google.com/search?&q=" . $keyword;
    $google_start = "&start=" . $page_number;
    $baidu_start = "&pn=" . $page_number;

// fetch baidu
// $baidu_content = file_get_contents($baidu_url);
    $ch_b = curl_init();
    curl_setopt($ch_b, CURLOPT_URL, $baidu_url);
    curl_setopt($ch_b, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch_b, CURLOPT_HEADER, 0);
    curl_setopt($ch_b, CURLOPT_FOLLOWLOCATION, 1);
    $baidu_content = curl_exec($ch_b);
    $baidu_content = preg_replace('/\"\//', '"http://www.baidu.com/', $baidu_content);
    $dom_bd = HtmlDomParser::str_get_html( $baidu_content );
    $baidu_head = $dom_bd->find('head', 0);
    $baidu_nav = $dom_bd->find('.s_tab', 0);
    $baidu_content = $baidu_head . $baidu_nav . $dom_bd->find('#content_left',0);
    // var_dump($baidu_content);
    // var_dump($baidu_head);
    curl_close($ch_b);

// fetch google
    $ch_g = curl_init();
    $cookie_file = dirname(__FILE__).'/cookie.txt';
    curl_setopt($ch_g, CURLOPT_URL, $google_url);
    curl_setopt($ch_g, CURLOPT_HEADER, 0);
    curl_setopt($ch_g, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch_g, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch_g, CURLOPT_COOKIEJAR, $cookie_file); 
    curl_setopt($ch_g, CURLOPT_CONNECTTIMEOUT, 10);
    // curl_setopt($ch_g, CURLOPT_TIMEOUT, 30);
    $google_content = curl_exec($ch_g);
    $google_content = preg_replace('/\"\//', '"http://www.google.com/', $google_content);
    $google_content = iconv('GBK', 'utf-8', $google_content);
    $dom_gg = HtmlDomParser::str_get_html( $google_content );
    $google_head = $dom_gg->find('head', 0);
    $google_modeselector = $dom_gg->find('#modeselector', 0);
    $google_tbd = $dom_gg->find('#tbd', 0);
    $google_content = $google_head . $google_modeselector . $google_tbd . $dom_gg->find('#center_col', 0);
    curl_close($ch_g);
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
            <!-- <iframe src="http://www.baidu.com/s?wd=<?php echo "$keyword" ?>" frameborder="0" id="baidu-frame" scrolling="auto"></iframe> -->
            <?php echo $baidu_content ?>
        </div> 
        <div id="google-content">
            <!-- <iframe src="" frameborder="0" scrolling="auto" id="google-frame"></iframe> -->
<!--             <div id='cse' style='width: 100%;'>Loading</div>
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
              customSearchControl.execute("<?php echo $keyword_origin ?>");
              }, true);
            </script>
 -->        
            <?php echo $google_content ?>
        </div>
    </div>
</body>
</html>