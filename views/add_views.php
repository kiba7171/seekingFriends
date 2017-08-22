<?$titlePage='Добавить новую запись'?>
<?php include __DIR__ . '/../templates/templates_header.php'; ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        function hideBtn(){
            $('#upload').hide();
            $('#res').html("Идет загрузка файла");
        }
        function handleResponse(mes) {
            $('#upload').show();
            if (mes.errors != null) {
                $('#res').html("Возникли ошибки во время загрузки файла: " + mes.errors);
            }
            else {
                $('#res').html("Файл загружен");
            }
        }
    </script>
<body>
<div id="page">
    <div id="whole">

<div class="post">
    <div class="entry">
    <form method="post">
        <p class="error"><?=$this->error?></p>
        <p><b>Заголовок записи:</b></p>
        <p><textarea name="title" cols="100" rows="3"><?=$title?></textarea></p>
        <p><b>Текст статьи:</b></p>
        <p><textarea name="content" cols="100" rows="30"><?=$content?></textarea></p>
        <p><input type="submit" value="отправить"></p>
    </form>

    <form method="post" target="hiddenframe" enctype="multipart/form-data" onsubmit="hideBtn();">
        <input type="file" id="image" name="image" />
        <input type="submit" name="upload" id="upload" value="Загрузить" />
    </form>
    <div id="res"></div>
    <iframe id="hiddenframe" name="hiddenframe" style="width:0px; height:0px; border:0px"></iframe>
</div>
    <div style="clear: both;">&nbsp;</div>
</div>
</div>

    <!-- end #page -->
<?php include __DIR__ . '/../templates/templates_footer.php'; ?>