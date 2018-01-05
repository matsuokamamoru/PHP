
{if $smarty.const.DEBUG == 0}
<!-- <a href="http://click.dtiserv2.com/Click/2006005-6-171068" target="_blank" style="text-align: center;"><img src="http://affiliate.dtiserv.com/image/carib/06-460-03.gif" border="0" width="320"></a> -->
{assign var=adno value=1|rand:4}
{if $adno == 1}
{literal}
<script type="text/javascript">
var adstir_vars = {
  ver    : "4.0",
  app_id : "MEDIA-10d9ce2c",
  ad_spot: 4,
  center : false
};
</script>
{/literal}
{elseif $adno == 2}
{literal}
<script type="text/javascript">
var adstir_vars = {
  ver    : "4.0",
  app_id : "MEDIA-10d9ce2c",
  ad_spot: 5,
  center : false
};
</script>
{/literal}
{elseif $adno == 3}
{literal}
<script type="text/javascript">
var adstir_vars = {
  ver    : "4.0",
  app_id : "MEDIA-10d9ce2c",
  ad_spot: 6,
  center : false
};
</script>
{/literal}
{else}
{literal}
<script type="text/javascript">
var adstir_vars = {
  ver    : "4.0",
  app_id : "MEDIA-10d9ce2c",
  ad_spot: 11,
  center : false
};
</script>
{/literal}
{/if}
{literal}
<script type="text/javascript" src="http://js.ad-stir.com/js/adstir.js?20130527"></script>
{/literal}
{/if}
