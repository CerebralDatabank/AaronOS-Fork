<!DOCTYPE html>
<html>
    <head>
        <script defer src="script.js"></script>
        <style>
            body{
                font-family:monospace;
            }
            .zoom{
                font-size:2em;
            }
            .staff{
                white-space:nowrap;
            }
            .staff input{
                font-family:monospace;
                font-size:1em;
                border:none;
                color:#000;
                background:none;
                cursor:pointer;
                width:2ch;
            }
            .staff input:hover{
                text-shadow:0 0 3px #3390FF;
            }
            .staff input:focus{
                outline:none;
                color:#3390FF;
            }
            .staff input::selection{
                background:none;
            }
            .lyric{
                font-family:monospace;
                font-size:1em;
                border:none;
                color:#000;
                background:none;
                width:95%;
            }
            .lyric:hover{
                text-shadow:0 0 3px #3390FF;
            }
            .lyric:focus{
                outline:none;
                color:#3390FF;
            }
            .lyric::selection{
                background:#3390FF;
                color:#FFF;
            }
            #tab{
                color:#7F7F7F;
            }
            #text{
                width:95%;
            }
            .del{
                color:#F00;
                cursor:pointer;
            }
            .delconfirm{
                color:#FFF;
                background:#F00;
            }
            .ins{
                color:#3390FF;
                cursor:pointer;
            }
        </style>
    </head>
    <body>
        <div id="tab" class="zoom" onclick="tabClick(event)" onkeyup="tabKeyPress(event)"></div>
        <button onclick="newStaff(event)">New Staff</button><br><br>
        <button onclick="toggleZoom()">Toggle Zoom</button><br><br>
        <button onclick="convertToText()">Convert to Text</button> <button onclick="convertToJSON()">Convert to JSON</button><br>
        <button onclick="convertFromText()" disabled="true">Convert from Text</button> <button onclick="convertFromJSON()">Convert from JSON</button><br><br>
        <textarea id="text"></textarea>
    </body>
</html>