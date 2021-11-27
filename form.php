<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>app</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
    <script>
    $(function() {
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
        $("#sample").autocomplete({
            source: "./autocomplete.php"
        });

        const input = document.querySelector('input');
        var input_val = $('.input').val();

        input.addEventListener('input', updateValue);

        function updateValue(e) {
            var result = list.some(function(val) {
                return val == input_val;
            });
            console.log(result);
        }
    });
    </script>
</head>

<body>
    <input name="name" class="input" />
    <p id="values"></p>

</body>

</html>