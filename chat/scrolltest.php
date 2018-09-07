<head>
    <script type="text/javascript">
        function ChangeScrollAmount () {
            var marquee = document.getElementById ("myMarquee");
            var input = document.getElementById ("myInput");

            marquee.scrollAmount = 25;
        }
    </script>
</head>
<body>
    <marquee id="myMarquee" style="width:150px;" scrollamount="10" onmouseover="ChangeScrollAmount ();">Hi There!</marquee>

    <br />
    <input id="myInput" type="text" value="20" />
    <button onclick="ChangeScrollAmount ();">Change scrollAmount!</button>
</body>