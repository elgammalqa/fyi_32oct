<!DOCTYPE html>
<html>
<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
    <meta charset="utf-8"/>
    <title>View PDF jQuery</title>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
    
    <div class="container">
        <h1>View PDF with jQuery</h1>
        <div id="viewpdf"></div>
    </div>

    <script src="jquery.min.js"></script>
    <script src="pdfobject.min.js"></script>
    <script>
        var viewer = $('#viewpdf');
        PDFObject.embed('sample.pdf', viewer);
    </script>
</body>
</html>