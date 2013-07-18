<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>Searching</title>
    <link rel='stylesheet' href='www.google.com/cse/style/look/default.css' type='text/css'/>
</head>
<body>
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
      customSearchControl.execute("VW GTI");
    }, true);
    </script>
</body>
</html>