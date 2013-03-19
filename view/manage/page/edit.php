<h3>Редактирование страницы</h3>
<p>
<a href="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars($file) ?></a>
</p>

<form method="post">
    <textarea name="content" class="tinymce" style="width:100%;height:400px"><?= htmlspecialchars($content) ?></textarea>
    <input type="submit" name="preview" value="Предпросмотр" />
    <input type="submit" name="save-page" value="Сохранить" />
	<a href="javascript:;" onclick="$('textarea.tinymce').tinymce().show();return false;">Расширенный режим</a>
	<a href="javascript:;" onclick="$('textarea.tinymce').tinymce().hide();return false;">Простой режим</a>
</form>

<div>
<h4 style="background: #888; color: white;">Предпросмотр</h4>
<?= $content ?>
</div>


<script type="text/javascript" src="/js/tiny/jquery.tinymce.js"></script>
<script type="text/javascript">
    $().ready(function() {
        $('textarea.tinymce').tinymce({
            // Location of TinyMCE script
            script_url : '/js/tiny/tiny_mce.js',

            // General options
            theme : "advanced",
            plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

            // Theme options
            theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2 : "cut,copy,paste,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            //theme_advanced_resizing : true,

            // Example content CSS (should be your site CSS)
            content_css : "/css/KeepItSimple.css",

            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "lists/template_list.js",
            external_link_list_url : "lists/link_list.js",
            external_image_list_url : "lists/image_list.js",
            media_external_list_url : "lists/media_list.js",

            // Replace values for the template plugin
            template_replace_values : {
                username : "Some User",
                staffid : "991234"
            }
        });
    });
</script>
