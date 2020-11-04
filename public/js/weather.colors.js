// get all weather tables
var tables = document.getElementsByClassName('weather-table');

// define which colours correspond to which wind/temp
var windColours = {999:"#700", 74:"#a00", 64:"#d30", 55:"#f30", 47:"#f63", 39:"#f96", 32:"#fc9", 25:"#ff8", 20:"#afa", 13:"#cff", 8:"#9ff", 5:"#9cf", 1:"#69f"};

// define the table headers that we want to index
var windIndexes = [1, 2];

// go through all tables
for (var i = 0; i < tables.length; i++) {
    // go through all rows (skipping headers)
    for (var j = 1; j < tables[i].rows.length; j++) {
        // go through all wind cells in each row
        for (var k = 0; k < windIndexes.length; k++) {
            var cell = tables[i].rows[j].cells[windIndexes[k]];
            var wind = parseFloat(cell.textContent);
            var color = getColorForWind(wind);
            //cell.background = color;
            $("<i style='color: " + color + "' class='pl-1 fa fa-circle'></i>").appendTo(cell);
        }
    }
}

function getColorForWind(wind) {
    for (const [cap, col] of Object.entries(windColours)) {
        if (wind <= cap) {
            return col;
        }
    }
}