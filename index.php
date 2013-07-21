<?php 
include './vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

$baidu_url = '';
$google_url = '';
$baidu_content = 'Nothing';
$google_content = 'Nothing';
$keyword = '';
$current_page = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$self_page = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$previous_page = '';
$next_page = $current_page . '&start=' . 10;


if (isset($_GET['keyword'])) {
    $keyword_origin = $_GET['keyword'];
    $keyword = urlencode($keyword_origin);
    $baidu_url = "http://www.baidu.com/baidu?wd=" . $keyword;
    $google_url = "http://www.google.com/search?&ie=utf-8&q=" . $keyword;
    if (isset($_GET['start'])) {
        $page_number = $_GET['start'];
        $next_page = $self_page.'?keyword='.$keyword.'&start='.strval((int)$page_number + 10);
        if ($page_number > 10) {
            $previous_page = $self_page.'?keyword='.$keyword.'&start='.strval((int)$page_number - 10);
        }
        $google_start = "&start=" . $page_number;
        $baidu_start = "&pn=" . $page_number;
        $baidu_url = $baidu_url . $baidu_start;
        $google_url = $google_url . $google_start;
    }

// fetch baidu
    $ch_b = curl_init();
    curl_setopt($ch_b, CURLOPT_URL, $baidu_url);
    curl_setopt($ch_b, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch_b, CURLOPT_HEADER, 0);
    curl_setopt($ch_b, CURLOPT_FOLLOWLOCATION, 1);
    $baidu_content = curl_exec($ch_b);
    $baidu_content = preg_replace('/\"\//', '"http://www.baidu.com/', $baidu_content);
    $dom_bd = HtmlDomParser::str_get_html( $baidu_content );
    // $baidu_head = $dom_bd->find('head', 0);
    $baidu_nav = $dom_bd->find('.s_tab', 0);
    $baidu_relevance = $dom_bd->find('#rs', 0);
    $baidu_content = $baidu_nav.$dom_bd->find('#content_left',0).$baidu_relevance;
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
    $google_content = preg_replace('/<br>/', '', $google_content);
    $google_content = iconv('GBK', 'utf-8', $google_content);
    $dom_gg = HtmlDomParser::str_get_html( $google_content );
    // $google_head = $dom_gg->find('head', 0);
    $google_modeselector = $dom_gg->find('#modeselector', 0);
    $google_tbd = $dom_gg->find('#tbd', 0);
    $google_content = '<div>'.$google_modeselector.$google_tbd.'</div>'.$dom_gg->find('#center_col', 0);
    curl_close($ch_g);
};

function print_search_form($keyword, $previous_page, $next_page){
    printf ('
    <div class="search-form">
        <form action="index.php" method="get" class="keyword-form">
            <span class="s_ipt_wr">
                <input type="text" name="keyword" id="kw" value = "%s" class="text s_ipt">
            </span> 
            <span class="s_btn_wr">
                <input type="submit" value="Search" class="s_btn">
            </span>
        </form>
        <div class="form-nav">
            <a href="%s">上一页</a><a href="%s">下一页</a>
        </div>
    </div>', $keyword, $previous_page, $next_page);
};
?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>Searching</title>
    <link rel="stylesheet" href="stylesheets/main.css">
    <link rel="stylesheet" href="stylesheets/screen.css">
    <script src="components/jquery/jquery.js"></script>
</head>
<body>
    <?php print_search_form($keyword, $previous_page, $next_page); ?>
    <div class="wrapper">
        <div id="baidu-content">
            <?php echo $baidu_content ?>
        </div> 
        <div id="google-content">
            <?php echo $google_content ?>
        </div>
    </div>
    <?php print_search_form($keyword, $previous_page, $next_page); ?>
</body>
</html>