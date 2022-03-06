<?php
require("config_1.php");
?>

<head>
    <meta charset="utf-8">
    <title>Auto Complete</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
</head>

<body>
    <input placeholder="Enter some text" name="name" id="sample" />
    <div id="parent-div">
    </div>

</body>
<script>
const list = new Array(
    'AWS',
    'Bootstrap',
    'C',
    'CakePHP',
    'C#',
    'C++',
    'COBOL',
    'CSS',
    'Docker',
    'Go',
    'Git',
    'HTTP',
    'iOS',
    'Java',
    'JavaScript',
    'JIRA',
    'Kotlin',
    'Laravel',
    'MATLAB',
    'MySQL',
    'Oracle Database',
    'Perl',
    'PHP',
    'PostgreSQL',
    'Python',
    'R',
    'React',
    'Ruby',
    'Ruby on Rails',
    'Rust',
    'SVN',
    'SSL',
    'SQLite',
    'TypeScript',
    'Vue.js'
);
$(function() {
    $("#sample").autocomplete({
        source: "./autocomplete.php"
    });
});

let reviewArea = document.getElementById('sample');
reviewArea.addEventListener('change', inputChange);

function inputChange() {
    var fome_x_name = $(this).val();
    if (list.indexOf(fome_x_name) != -1) {

        var span_element = document.createElement("span"),
            label_element = document.createElement("label"),
            i_element = document.createElement("i"),
            input_element = document.createElement("input"),
            newContent = document.createTextNode(fome_x_name),
            i = 0;
        span_element.appendChild(newContent);
        span_element.setAttribute("id", "child-span" + i + "");
        span_element.setAttribute("class", "skil_tag");
        i_element.setAttribute("class", "far fa-times-circle tag");
        input_element.setAttribute("type", "button");

        i++;

        var parentDiv = document.getElementById("parent-div");
        parentDiv.insertBefore(span_element, parentDiv.firstChild);
        span_element.appendChild(label_element, span_element.firstChild);
        label_element.insertBefore(i_element, label_element.firstChild);
        label_element.insertBefore(input_element, label_element.firstChild);
        $(this).val('');

        $(document).on('click', '.far.fa-times-circle', function() {
            $(this).parents(".skil_tag").hide();
        });
    }
}
</script>

</html>