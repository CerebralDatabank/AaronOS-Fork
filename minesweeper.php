<!DOCTYPE html>
<html>
    <head>
        <title>aOS Minesweeper</title>
        <link rel="stylesheet" href="customStyles/Windows98/aosCustomStyle.css">
        <link rel="stylesheet" href="" id="minecraft">
        <style>
            @font-face{
                font-family: "aosProFont";
                src:
                    url('ProFont/ProFontOnline.ttf') format('truetype'),
                    url('ProFont/ProFontOnline.woff') format('woff'),
                    url('ProFont/ProFontOnline.eot'),
                    url('ProFont/ProFontOnline.svg') format('svg');
            }
            div{
                position:absolute;
                overflow:hidden;
            }
            button:focus{
                outline:0;
            }
        </style>
    </head>
    <body style="background-color:#BDBDBD">
        <div id="MSwField" style="margin-bottom:3px;"></div>
        <div id="MSwControls">
            <button onclick="apps.minesweeper.vars.firstTurn = 1;apps.minesweeper.vars.newGame()">New Game</button>
            <button onclick="apps.minesweeper.vars.difficulty()">Difficulty</button>
            <button onclick="apps.minesweeper.vars.settings()">Settings</button>
            <button onclick="apps.minesweeper.vars.darkMode()">Dark Mode</button>
            <button onclick="apps.minesweeper.vars.minecraftMode()">Minecraft Mode</button>
            <span style="font-family:aosProFont;font-size:12px;">B: <span id="MSwMines">0</span>, F: <span id="MSwFlags">0</span></span><br>
            Dig = Left Click | Flag = Right Click
        </div>
    </body>
    <script defer>
        function getId(target){
            return document.getElementById(target);
        }
        var minecraftMode = 0;
        var apps = {
            minesweeper: {
                vars: {
                    appInfo: 'The Minesweeper clone written for aOS.',
                    dims: [24, 24],
                    area: 576,
                    mines: 99,
                    flags: 0,
                    digs: 0,
                    minefield: [
                        [0, 0],
                        [0, 0]
                    ],
                    flagfield: [
                        [0, 0],
                        [0, 0]
                    ],
                    minecraftMode: function(){
                        getId("minecraft").setAttribute("href", "minecraftsweeper.css?" + Math.random());
                        minecraftMode = 1;
                    },
                    newGame: function(firstX, firstY){
                        if(this.firstTurn){
                            this.flagfield = [];
                            for(var i = 0; i < this.dims[1]; i++){
                                this.flagfield.push([]);
                                for(var j = 0; j < this.dims[0]; j++){
                                    this.flagfield[i].push(0);
                                }
                            }
                            
                            this.digs = 0;
                            this.area = this.dims[0] * this.dims[1];
                            this.minefield = [];
                            for(var i = 0; i < this.dims[1]; i++){
                                this.minefield.push([]);
                                for(var j = 0; j < this.dims[0]; j++){
                                    this.minefield[i].push(0);
                                }
                            }
                            this.flags = 0;
                        }else{
                            this.flags = 0;
                            while(this.flags < this.mines){
                                var tempX = Math.floor(Math.random() * this.dims[0]);
                                var tempY = Math.floor(Math.random() * this.dims[1]);
                                if(!this.minefield[tempY][tempX] && !(tempX === firstX && tempY === firstY && this.safe)){
                                    this.minefield[tempY][tempX] = 1;
                                    this.flags++;
                                }
                            }
                            this.flags = 0;
                        }
                        if(this.firstTurn){
                            var tempHTML = "<br><br><br>";
                            for(var i in this.minefield){
                                tempHTML += "<div style='font-size:0;position:relative;white-space:nowrap;'>";
                                for(var j in this.minefield[i]){
                                    tempHTML += "<button id='MSwB" + j + "x" + i + "' onclick='apps.minesweeper.vars.checkBlock(" + j + "," + i + ")' oncontextmenu='apps.minesweeper.vars.flagBlock(" + j + "," + i + ");event.stopPropagation();return false;' style='width:20px;height:20px;'></button>";
                                    tempHTML += "<div id='MSwF" + j + "x" + i + "' style='position:relative;background:none !important;display:inline-block;width:20px;margin-left:-13px;margin-right:-7px;margin-bottom:1px;font-family:aosProFont;font-size:12px;pointer-events:none;'></div>"
                                }
                                tempHTML += "<div style='position:relative;background:none !important;display:inline-block;width:3px;margin:0px;height:3px;pointer-events:none;'></div></div>";
                            }
                            getId("MSwField").innerHTML = tempHTML;
                            getId("MSwMines").innerHTML = this.mines;
                            getId("MSwFlags").innerHTML = this.flags;
                        }
                    },
                    dark: 0,
                    darkMode: function(){
                        this.dark = Math.abs(this.dark - 1);
                        document.body.style.filter = 'invert(' + this.dark + ')';
                        if(this.dark){
                            document.body.style.backgroundColor = "#424242";
                        }else{
                            document.body.style.backgroundColor = "#BDBDBD";
                        }
                    },
                    firstTurn: 1,
                    difficulty: function(){
                        var tempScreenWidth = window.innerWidth;
                        var tempScreenHeight = window.innerHeight;
                        var btn = parseInt(prompt("Please choose a difficulty level:\n1: Beginner (8x8, 10)\n2: Intermediate (16x16, 40)\n3: Expert (24x24)\n4: Fill Screen\n5: Custom"));
                        if(btn){
                            switch(btn){
                                case 1:
                                    apps.minesweeper.vars.dims = [8, 8];
                                    apps.minesweeper.vars.mines = 10;
                                    apps.minesweeper.vars.firstTurn = 1;
                                    apps.minesweeper.vars.newGame();
                                    break;
                                case 2:
                                    apps.minesweeper.vars.dims = [16, 16];
                                    apps.minesweeper.vars.mines = 40;
                                    apps.minesweeper.vars.firstTurn = 1;
                                    apps.minesweeper.vars.newGame();
                                    break;
                                case 3:
                                    apps.minesweeper.vars.dims = [24, 24];
                                    apps.minesweeper.vars.mines = 99;
                                    apps.minesweeper.vars.firstTurn = 1;
                                    apps.minesweeper.vars.newGame();
                                    break;
                                case 4:
                                    apps.minesweeper.vars.dims = [
                                        (tempScreenWidth - 16) / 20 - 1,
                                        (tempScreenHeight - 70) / 20 - 1
                                    ];
                                    apps.minesweeper.vars.mines = Math.round(apps.minesweeper.vars.dims[0] * apps.minesweeper.vars.dims[1] * 0.17);
                                    apps.minesweeper.vars.firstTurn = 1;
                                    apps.minesweeper.vars.newGame();
                                    break;
                                case 5:
                                    var width = prompt("How wide will your minefield be?");
                                    var height = prompt("How tall will your minefield be?");
                                    var numOfMines = prompt("How many bombs will your minefield contain?\n\nLeave blank for 17% fill.");
                                    if(parseInt(width) > 0 && parseInt(height) > 0 && parseInt(numOfMines || Math.round(parseInt(width) * parseInt(height) * 0.17)) < parseInt(width) * parseInt(height) && parseInt(numOfMines || Math.round(parseInt(width) * parseInt(height) * 0.17)) > 0){
                                        apps.minesweeper.vars.dims = [parseInt(width), parseInt(height)];
                                        apps.minesweeper.vars.mines = parseInt(numOfMines || Math.round(parseInt(width) * parseInt(height) * 0.17));
                                        apps.minesweeper.vars.firstTurn = 1;
                                        apps.minesweeper.vars.newGame();
                                    }else{
                                        alert("Failed to start game, one of your rules is invalid.\n\nWidth: " + parseInt(width) + "\nHeight: " + parseInt(height) + "\nBombs: " + parseInt(numOfMines || Math.round(parseInt(width) * parseInt(height) * 0.17)));
                                    }
                                    break;
                                default:
                                    alert("Error - unknown menu option. Oof.");
                            }
                        }
                    },
                    grid: 1,
                    clear: 1,
                    safe: 1,
                    easyClear: 1,
                    settings: function(){
                        var btn = parseInt(prompt("Please choose a setting to toggle:\n1: Omnipresent Grid (" + this.grid + ")\n2: Automatic Clearing (" + this.clear + ")\n3: Safe Mode (" + this.safe + ")\n4: Easy Clear (" + this.easyClear + ")\n5: DEBUG"));
                        if(btn){
                            switch(btn){
                                case 1:
                                    this.grid = Math.abs(this.grid - 1);
                                    break;
                                case 2:
                                    this.clear = Math.abs(this.clear - 1);
                                    break;
                                case 3:
                                    this.safe = Math.abs(this.safe - 1);
                                    break;
                                case 4:
                                    this.easyClear = Math.abs(this.easyClear - 1);
                                    break;
                                case 5:
                                    this.cheat();
                                    break;
                                default:
                                    alert("Error - unknown menu option. Oof.");
                            }
                        }
                    },
                    flagBlock: function(x, y){
                        if(!this.firstTurn){
                            if(this.flagfield[y][x]){
                                this.flagfield[y][x] = 0;
                                if(!minecraftMode){
                                    getId("MSwF" + x + "x" + y).innerHTML = "";
                                }else{
                                    getId("MSwB" + x + "x" + y).className = "";
                                }
                                this.flags--;
                            }else{
                                this.flagfield[y][x] = 1;
                                if(!minecraftMode){
                                    getId("MSwF" + x + "x" + y).innerHTML = "F";
                                }else{
                                    getId("MSwB" + x + "x" + y).className = "mcflagoff";
                                }
                                this.flags++;
                            }
                            getId("MSwFlags").innerHTML = this.flags;
                            if(this.flags === this.mines){
                                this.showMines();
                            }
                        }
                    },
                    checkBlock: function(x, y){
                        if(this.firstTurn){
                            this.firstTurn = 0;
                            this.newGame(x, y);
                        }
                        if(this.flagfield[y][x]){
                            /*
                            this.flagfield[y][x] = 0;
                            getId("MSwF" + x + "x" + y).innerHTML = "";
                            this.flags--;
                            */
                        }else{
                            if(!minecraftMode){
                                getId("MSwB" + x + "x" + y).style.opacity = "0." + this.grid;
                            }else{
                                getId("MSwB" + x + "x" + y).className = "mcdirt";
                            }
                            getId("MSwB" + x + "x" + y).style.pointerEvents = "none";
                            if(this.minefield[y][x]){
                                this.showMines();
                                if(minecraftMode){
                                    getId("MSwB" + x + "x" + y).className = "mcstone";
                                }
                            }else{
                                this.digs++;
                                /*
                                if(this.digs === this.area - this.mines){
                                    this.showMines();
                                }else{
                                */
                                    var nearby = 0;
                                    try{
                                        if(this.minefield[y - 1][x - 1]){
                                            nearby++;
                                        }
                                    }catch(minefieldEdge){}
                                    try{
                                        if(this.minefield[y - 1][x]){
                                            nearby++;
                                        }
                                    }catch(minefieldEdge){}
                                    try{
                                        if(this.minefield[y - 1][x + 1]){
                                            nearby++;
                                        }
                                    }catch(minefieldEdge){}
                                    try{
                                        if(this.minefield[y][x - 1]){
                                            nearby++;
                                        }
                                    }catch(minefieldEdge){}
                                    try{
                                        if(this.minefield[y][x + 1]){
                                            nearby++;
                                        }
                                    }catch(minefieldEdge){}
                                    try{
                                        if(this.minefield[y + 1][x - 1]){
                                            nearby++;
                                        }
                                    }catch(minefieldEdge){}
                                    try{
                                        if(this.minefield[y + 1][x]){
                                            nearby++;
                                        }
                                    }catch(minefieldEdge){}
                                    try{
                                        if(this.minefield[y + 1][x + 1]){
                                            nearby++;
                                        }
                                    }catch(minefieldEdge){}
                                    if(nearby){
                                        getId("MSwF" + x + "x" + y).innerHTML = nearby;
                                        if(!minecraftMode){
                                            getId("MSwF" + x + "x" + y).style.opacity = "0.5";
                                        }
                                        if(this.easyClear){
                                            getId("MSwB" + x + "x" + y).style.pointerEvents = "";
                                            getId("MSwB" + x + "x" + y).setAttribute("onclick", "apps.minesweeper.vars.eClear(" + x + "," + y + ")");
                                            getId("MSwB" + x + "x" + y).setAttribute("oncontextmenu", "");
                                        }
                                    }else if(this.clear){
                                        if(this.blockModdable(x - 1, y - 1)){
                                            this.checkBlock(x - 1, y - 1);
                                        }
                                        if(this.blockModdable(x, y - 1)){
                                            this.checkBlock(x, y - 1);
                                        }
                                        if(this.blockModdable(x + 1, y - 1)){
                                            this.checkBlock(x + 1, y - 1);
                                        }
                                        if(this.blockModdable(x - 1, y)){
                                            this.checkBlock(x - 1, y);
                                        }
                                        if(this.blockModdable(x + 1, y)){
                                            this.checkBlock(x + 1, y);
                                        }
                                        if(this.blockModdable(x - 1, y + 1)){
                                            this.checkBlock(x - 1, y + 1);
                                        }
                                        if(this.blockModdable(x, y + 1)){
                                            this.checkBlock(x, y + 1);
                                        }
                                        if(this.blockModdable(x + 1, y + 1)){
                                            this.checkBlock(x + 1, y + 1);
                                        }
                                    }
                                /*
                                }
                                */
                            }
                        }
                    },
                    eClear: function(x, y){
                        var nearby = 0;
                        try{
                            if(this.flagfield[y - 1][x - 1]){
                                nearby++;
                            }
                        }catch(minefieldEdge){}
                        try{
                            if(this.flagfield[y - 1][x]){
                                nearby++;
                            }
                        }catch(minefieldEdge){}
                        try{
                            if(this.flagfield[y - 1][x + 1]){
                                nearby++;
                            }
                        }catch(minefieldEdge){}
                        try{
                            if(this.flagfield[y][x - 1]){
                                nearby++;
                            }
                        }catch(minefieldEdge){}
                        try{
                            if(this.flagfield[y][x + 1]){
                                nearby++;
                            }
                        }catch(minefieldEdge){}
                        try{
                            if(this.flagfield[y + 1][x - 1]){
                                nearby++;
                            }
                        }catch(minefieldEdge){}
                        try{
                            if(this.flagfield[y + 1][x]){
                                nearby++;
                            }
                        }catch(minefieldEdge){}
                        try{
                            if(this.flagfield[y + 1][x + 1]){
                                nearby++;
                            }
                        }catch(minefieldEdge){}
                        if(nearby === parseInt(getId("MSwF" + x + "x" + y).innerHTML)){
                            if(this.blockModdable(x - 1, y - 1)){
                                this.checkBlock(x - 1, y - 1);
                            }
                            if(this.blockModdable(x, y - 1)){
                                this.checkBlock(x, y - 1);
                            }
                            if(this.blockModdable(x + 1, y - 1)){
                                this.checkBlock(x + 1, y - 1);
                            }
                            if(this.blockModdable(x - 1, y)){
                                this.checkBlock(x - 1, y);
                            }
                            if(this.blockModdable(x + 1, y)){
                                this.checkBlock(x + 1, y);
                            }
                            if(this.blockModdable(x - 1, y + 1)){
                                this.checkBlock(x - 1, y + 1);
                            }
                            if(this.blockModdable(x, y + 1)){
                                this.checkBlock(x, y + 1);
                            }
                            if(this.blockModdable(x + 1, y + 1)){
                                this.checkBlock(x + 1, y + 1);
                            }
                        }
                    },
                    blockModdable: function(x, y){
                        if(x > this.dims[0] - 1 || y > this.dims[1] - 1){
                            return false;
                        }
                        if(x < 0 || y < 0){
                            return false;
                        }
                        if(this.flagfield[y][x]){
                            return false;
                        }
                        if(getId("MSwB" + x + "x" + y).style.pointerEvents === "none"){
                            return false;
                        }
                        return true;
                    },
                    showMines: function(){
                        for(var i in this.minefield){
                            for(var j in this.minefield[i]){
                                getId("MSwB" + j + "x" + i).style.pointerEvents = "none";
                                if(this.minefield[i][j]){
                                    if(this.flagfield[i][j]){
                                        if(!minecraftMode){
                                            getId("MSwF" + j + "x" + i).innerHTML = "<b>F</b>";
                                            getId("MSwF" + j + "x" + i).style.color = "#0A0";
                                        }else{
                                            getId("MSwB" + j + "x" + i).className = "mcflagon";
                                        }
                                    }else{
                                        if(!minecraftMode){
                                            getId("MSwF" + j + "x" + i).innerHTML = "<b>B</b>";
                                            getId("MSwF" + j + "x" + i).style.color = "#F00";
                                        }else{
                                            getId("MSwB" + j + "x" + i).className = "mctnt";
                                        }
                                    }
                                }
                            }
                        }
                    },
                    cheat: function(){
                        for(var i in this.minefield){
                            for(var j in this.minefield[i]){
                                if(this.minefield[i][j]){
                                    getId("MSwB" + j + "x" + i).style.filter = "contrast(0.5) sepia(1) hue-rotate(-40deg) saturate(3)";
                                }
                            }
                        }
                    }
                }
            }
        };
        
        apps.minesweeper.vars.firstTurn = 1;
        apps.minesweeper.vars.newGame();
    </script>
</html>