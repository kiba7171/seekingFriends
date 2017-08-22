<?$titlePage='Ошибка 404'?>
<?php include __DIR__ . '/../templates/templates_header.php'; ?>
<body>
<div id="page">
    <div id="content">
Запрашиваемая страница не найдена!
    </div>
</div>
<?php
session_start();

if(!empty($_SESSION))
{
    include __DIR__ . '/../templates/templates_sidebar2.php';
}
else
{
    include __DIR__ . '/../templates/templates_sidebar.php';
}

?>

<!-- end #page -->
<?php include __DIR__ . '/../templates/templates_footer.php'; ?>