<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html>
<head>
<script language="JavaScript1.2" type="text/javascript" src="/almidon/js/common.js"></script>
<script language="JavaScript" type="text/javascript" src="/almidon/html/wysiwyg.js"></script>
<link rel="stylesheet" href="/almidon/css/adm.css">
<title>{$title}</title>
<script language="javascript">
{literal}
  function confirm_delete(o, idfield, id, desc) {
    if (window.confirm('"'+desc+'": Estas seguro de querer borrar este registro?')) {
        {/literal}location.href = '{$smarty.server.PHP_SELF}?o='+o+'&action=delete&'+idfield+'='+id;{literal}
    }
  }

  function confirm_delete2(o, idfield1, idfield2, id1, id2, desc) {
    if (window.confirm('"'+desc+'": Estas seguro de querer borrar este registro?')) {
        {/literal}location.href = '{$smarty.server.PHP_SELF}?o='+o+'&action=delete&'+idfield1+'='+id1+'&'+idfield2+'='+id2;{literal}
    }
  }
{/literal}
</script>
</head>
<body>
{include_video_service src=$smarty.get.src type=$smarty.get.type width="380" height="312"}
</body>
</html>
