// get all weather tables
var tables = document.getElementsByClassName('weather-table');

// define which colours correspond to which wind/temp
var windColours = {74:"#700", 64:"#a00", 55:"#d30", 47:"#f30", 39:"#f63", 32:"#f96", 25:"#fc9", 20:"#ff8", 13:"#afa", 8:"#cff", 5:"#9ff", 1:"#9cf", 0:"#69f"};

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
            cell.style.background = color;
        }
    }
}

function getColorForWind(wind) {
    for (const [cap, col] of Object.entries(windColours)) {
        if (wind < cap) {
            return col;
        }
    }
}