<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="строительство, ремонт, заявка, сервис9, сервис 9, service9, service 9, отделка, кафель">
    <meta name="description" content="Заявки на Ремонт, строительство, отделка зданий и сооружений">
    <title>SERVICE 9</title>
    <script src="/_js/jquery-1.11.1.min.js" ></script>
    <script src="/_js/bootstrap.min.js" ></script>
    <script src="/_js/jqxcore.js" ></script>
    <script type="text/javascript" src="/_js/jqxcore.js"></script>
    <script type="text/javascript" src="/_js/jqxdata.js"></script> 
    <script type="text/javascript" src="/_js/jqxbuttons.js"></script>
    <script type="text/javascript" src="/_js/jqxscrollbar.js"></script>
    <script type="text/javascript" src="/_js/jqxmenu.js"></script>
    <script type="text/javascript" src="/_js/jqxgrid.js"></script>
    <script type="text/javascript" src="/_js/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="/_js/jqxgrid.columnsresize.js"></script> 
    <script type="text/javascript" src="/_js/jqxgrid.sort.js"></script> 
    <script type="text/javascript" src="/_js/jqxcheckbox.js"></script> 
    <script type="text/javascript" src="/_js/jqxlistbox.js"></script>
    <script type="text/javascript" src="/_js/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="/_js/jqxgrid.filter.js"></script> 
    <script type="text/javascript" src="/_js/jqxgrid.grouping.js"></script> 
    <script type="text/javascript" src="/_js/jqxgrid.pager.js"></script> 
    <script type="text/javascript" src="/_js/jqxgrid.aggregates.js"></script> 
    <script type="text/javascript" src="/_js/globalization/globalize.js"></script>
    <script type="text/javascript" src="/_js/localization.js"></script> 
    <link rel="stylesheet" type="text/css" href="/_css/service9.css">
    <link rel="stylesheet" type="text/css" href="/_css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="/_css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/_css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/_css/jqx.base.css">
    <link rel="stylesheet" type="text/css" href="/_css/jqx.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/_css/bootstrap.ext.css">

<?php
    if ($_COOKIE["Theme"]) 
    { 
        echo '<style>';
        echo 'body';
        echo '{ background-image:url(..<?php echo ($_COOKIE["Theme"]) ?>)}';
        echo '</style>';
    }
?>

<script type="text/javascript">
function SetBottomMenu()
{
    BottomService9=$(".startline").height();
    BottomMenu=$(".mainmenu").height();
    DivHight=BottomService9-BottomMenu;
    $(".mainmenu").css({top: DivHight});
}

$(window).resize(function() {
    SetBottomMenu();
});

$(document).ready(function() { 
    $(".mainmenu").hide();
    $(".BtnMenu").hover(function(e) { $(this).toggleClass("inverse"); });
});

$(window).bind("load", function() {
    SetBottomMenu();
    $(".mainmenu").fadeIn(500);
});


// Menu Active
$(window).on('scroll',function(){
	var winScrollTop = $(window).scrollTop();
	if(winScrollTop >= 100){
		url2=$('body').css('background-image');
		url3=url2+' no-repeat top center fixed';
		$('#fake').css('background',url3);
		$('#fake').css('background-size','cover');
	}
});
</script>
</head>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
var yaParams = {ip_adress: "<? echo $_SERVER['REMOTE_ADDR'];?>",user_name: "<? echo $_SESSION['UserName'];?>",full_info: "<? echo $_SERVER['REMOTE_ADDR']."-".$_SESSION['UserName']."-".date("d.m.Y H:i:s");?>"};
//объявляем параметр ip_adress и записываем в него IP посетителя
</script> 
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter30045064 = new Ya.Metrika({id:30045064,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true, params:window.yaParams});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/30045064" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<body>
<div id="menu" class="menu">
    <div class="startline"></div>
        <?php include ('menu_service9.php');?>
        <div class="service9" align="center">
            <span style="color:#FFFFFF">SERVICE</span>
            <span style="color:#FFFFFF">9</span>
        </div>
</div>
<div id="content" >
    <div id="content-center" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  style="height:100%">
            <?php include '_application/views/'.$content_view; ?>
        </div>
    </div>
</div>
<div class="footer" align="center" style="display:none"> ВСЕ ПРАВА ЗАЩИЩЕНЫ &copy; 2009</div>
</body>
</html>