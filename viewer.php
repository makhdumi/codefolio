<?php
require_once 'project.php';

ini_set('display_errors','On');
error_reporting(E_ALL);

$project = getProjectObj( _get('id') );
$icon_dir = 'js/jstree/themes/eclipse';

$langs = array();
foreach ($project->extensions as $ext => $v) {
    if (file_exists("$icon_dir/$ext.gif"))
        $langs[$ext] = array('icon' => array('image' => "$icon_dir/$ext.gif"));
}
$langs['folder'] = array('icon' => array('image' => "$icon_dir/folder.gif"));
$langs['default'] = array('icon' => array('image' => "$icon_dir/file.gif"));

//Change version for display
$project->version = (double)$project->version ?
    'v'.$project->version : '<span style="font-style:italic">'.$project->version.'</span>';



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?=$project->name?> - Source Code</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/SyntaxHighlighter/shCore.css" rel="stylesheet" type="text/css" />
    <link href="css/SyntaxHighlighter/shCoreDefault.css" rel="stylesheet" type="text/css" />
    <link href="css/SyntaxHighlighter/shThemeDefault.css" rel="stylesheet" type="text/css" />
	<link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/pepper-grinder/jquery-ui.css" rel="stylesheet" />
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="js/SyntaxHighlighter/shCore.js"></script>
    <script type="text/javascript" src="js/SyntaxHighlighter/shBrushJava.js"></script>
    <script type="text/javascript" src="js/SyntaxHighlighter/shBrushCpp.js"></script>
    <script type="text/javascript" src="js/SyntaxHighlighter/shBrushPhp.js"></script>
    <script type="text/javascript" src="js/SyntaxHighlighter/shBrushSql.js"></script>
    <script type="text/javascript" src="js/SyntaxHighlighter/shBrushCss.js"></script>
    <script type="text/javascript" src="js/SyntaxHighlighter/shBrushJScript.js"></script>
    <script type="text/javascript" src="js/SyntaxHighlighter/shBrushXml.js"></script>
    <script type="text/javascript" src="js/SyntaxHighlighter/shBrushVhdl.js"></script>
    <script type="text/javascript" src="js/jstree/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/jstree/jquery.hotkeys.js"></script>
    <script type="text/javascript" src="js/jstree/jquery.jstree.js"></script>
    <script type="text/javascript" src="js/jstree/jquery.printElement.min.js"></script>
    <style type="text/css">
        li.jstree-open > a .jstree-icon {background:url("<?=$icon_dir?>/folder.gif") 0px 0px no-repeat !important;}
        li.jstree-closed > a .jstree-icon {background:url("<?=$icon_dir?>/folder.gif") 0px 0px no-repeat !important;}
        #codecontent {
            font-size: 12px;
        }
		.syntaxhighlighter { overflow-y: hidden !important; }
    </style>
</head>

<body>
<div id="header" class="widget ui-widget-content">
    <div style="float:left">
    <h1><?=$project->name?> <span style="font-weight: normal;font-size: 13px">(<?=implode(', ', $project->languages)?>)</span></h1>
    </div>
    <div style="float:right;">
        <input type="image" src="images/back.gif" />
        <input type="image" src="images/information.gif" />
        <input type="image" src="images/print.gif" onclick="$('#codecontent').find('table').parent().printElement(); return false;" />
        <input type="image" src="images/home.gif" />
    </div>
    <div style="clear:both"></div>
</div>
<div id="framecontent">
    <div id="filetree">
    <ul>
    <?php listProjectFiles($project);  ?>
    </ul>
    </div>
    <script type="text/javascript">
        $(function () {
            // Select the tree container using jQuery
            var tree = $('#filetree');
            tree.bind("loaded.jstree", function(event, data) {
                tree.jstree('open_all');
            })
                .jstree({
                        // the `plugins` array allows you to configure the active plugins on this instance
                        "plugins" : ["themes","html_data","ui","crrm","hotkeys","types"],
                        // each plugin you have included can have its own config object
                        "themes" : {"dots" : false },
                        "types": {
                            "types" : <?=json_encode($langs)?>
                        }
                        // it makes sense to configure a plugin only if overriding the defaults
                    })
                // Bind to when node is selected and show file's source code
                    .bind("select_node.jstree", function (event, data) {
                        if (!data.inst.is_leaf() || data.rslt.obj.attr('rel') == 'folder') return;
                        file = data.rslt.obj.attr('id');
                        console.log(data);
                        $.ajax({
                            type: 'POST',
                            url: 'ajax.php',
                            data: {func: 'get_file', id: <?=$project->id?>, file: file}
                        }).done(function(msg) {
                            $('#codecontent').html('<pre class="brush: '+file.substr(file.lastIndexOf('.')+1)+'">'+msg+"\n"+'</pre>');
                            SyntaxHighlighter.refresh();
                        });

                    });
        });

</script>

</div>
<div id="maincontent">
 <div id="codecontent">
    <pre class="brush: java">
    </pre>
</div>

</div>
<script type="text/javascript">
    SyntaxHighlighter.all();

</script>
</body>
</html>
