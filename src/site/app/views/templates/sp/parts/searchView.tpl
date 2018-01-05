
<div id="search_view" style="display:none; height: 100%; width:100%">
<header id="header">
<div class="hd_inner">
<h1><span>検索</span></h1>
<a href="javascript:;" id="close_search" class="btn_hd_back btn_hd"></a>
</div>
</header>

<section class="wrapper_search">
<h2 class="title_page">キーワード検索</h2>
<form accept-charset="UTF-8" action="{$smarty.const.URL_ROOT}search/index/" id="searchForm" method="get">
<input id="sp_search" class="searchForm" name="q" placeholder="気になるワードを入力" type="text" />
</form>
</section>{*<!-- /.wrapper_search -->*}

{include file="./hotword.tpl"}

</div>{*<!-- /#search_view -->*}
