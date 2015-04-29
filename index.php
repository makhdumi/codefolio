<?php
/**
 * Authors: Ahmed Ali Makhdoom
 * Created 12-06-18 7:50 PM
 */
require_once 'project.php';
require_once 'config.php';
require_once 'track.php';
$all_projects = getAllProjects();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" lang="en" xml:lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>CodeFolio</title>
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link type="text/css" rel="stylesheet" href="css/SyntaxHighlighter.css" />
	<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/pepper-grinder/jquery-ui.css" rel="stylesheet" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#content").tabs();
            $('#navlist').removeClass('ui-widget-header');
            $('#titlebar').addClass('ui-widget-header ui-corner-top');
        });
    </script>
    <style type="text/css">
        html {
            height: 100%;
        }
        body {
            background-color: #fff;
            font-size: 11px;
            height: 100%;
            overflow: scroll;
            overflow-y: scroll;
            overflow-x: hidden;
        }
        h1 {
            margin: 5px;
}
#content {
width: 700px;
min-height: 100%;
margin: 10px auto 0 auto;
overflow: hidden;
}
#footer {
width: 700px;
margin: 8px auto 15px auto;
text-align: center;
}
</style>
</head>
<body>
<div id="content">
<div id="titlebar">
<div style="margin:5px;padding:0">
<img src="images/title.png" alt="CodeFolio" /><br/>
<span style="font-weight: normal"> of Ahmed Ali Makhdoom</span>
</div>
        <ul id="navlist">
<? foreach ($all_projects as $language => $projects): ?>
    <li><a href="#<?=$projects[0]->language_internal?>-tab"><?=ucfirst($language)?></a></li>
<? endforeach; ?>
    <li><a href="#about-tab">About</a></li>
</ul>
    </div>
<? foreach ($all_projects as $language => $projects): ?>
<div id="<?=$projects[0]->language_internal?>-tab" style="width:100%;padding:0;margin:0">
    <? foreach ($projects as $p): ?>
<div class="ui-widget" style="margin: 15px">
    <div class="ui-state-hover ui-corner-top" style="padding: 0.2em .7em; 0.2em 0.2em; margin: 0">
        <?=$p->name?>
    <div style="float:right">
		<? if ($p->directory != null): ?><a href="viewer.php?id=<?=$p->id?>">source code</a><? endif; ?>
		<?= $p->directory != null && $p->demo != null ? ' | ' : ''?>
		<? if ($p->demo != null): ?><a href="<?=$p->demo?>">view demo</a><? endif; ?>
	</div>
        </div>
        <div class="project-entry ui-state-highlight ui-corner-bottom" style="padding: 0.8em; margin:0">
            <table><tr>
                <td><img src="<?='images'.DIRECTORY_SEPARATOR.$p->image?>" alt="<?=$p->name?>" style="margin-right: 10px"/></td>
                <td>
                    <?=$p->description?>
                </td>
            </tr></table>
        </div>
 </div>
        <? endforeach; ?>
</div>
<? endforeach; ?>
<div id="about-tab" style="width:100%;padding:0;margin:0">
    <div class="ui-widget" style="margin: 15px">
        <div class="ui-state-hover ui-corner-top" style="padding: 0.2em .7em; 0.2em 0.2em; margin: 0">
            About this website and its author
            <div style="float:right">
            </div>
        </div>
        <div class="project-entry ui-state-highlight ui-corner-bottom" style="padding: 0.8em; margin:0;">
            <? include 'about.php' ?>
        <div style="clear:both"></div>

        </div>
    </div>

</div>


</div>
<div id="footer">
    Copyright &copy; <?=date('Y')?> <?=USER_DISPLAY_NAME?>
</div>
</body>
</html>