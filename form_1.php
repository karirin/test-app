<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>Auto Complete</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
    <script>
    $(function() {
        $("#sample").autocomplete({
            source: "./autocomplete.php"
        });
    });
    </script>
</head>

<body>

    <form>
        <input type="text" id="sample" />
    </form>

</body>
<script>
const input = document.querySelector('input');
var sample = document.getElementById('sample');

sample.addEventListener('input', updateValue);

function updateValue(e) {
    var result = list.some(function(val) {
        return val == input;
    });
}
</script>

</html>