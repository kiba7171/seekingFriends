$(document).ready(function() {
    $(document).one("click", "#searchs", function ()
    {
        $('#searchs').css("height", "90px");
        $('#searchs-form').css("display", "block");
        $.post("controllers/Controller_search.php",
            {
                query: 1
            },
            function (data) {
                var data = JSON.parse(data);
                for (var id in data)
                {
                    $("select[name='city']").append($("<option value='" + data[id] + "'>" + data[id] + "</option>"));
                }
            });
    });
});
