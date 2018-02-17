function readFile(file, callback) {

    var rawFile = new XMLHttpRequest();

    rawFile.overrideMimeType("application/json");

    rawFile.open("GET", 'officesdata.json', true);

    rawFile.onreadystatechange = function() {

        if (rawFile.readyState === 4 && rawFile.status == "200") {

            callback(rawFile.responseText);

        }

    }

    rawFile.send(null);

}


//usage:

readFile("officesdata.json", function(text){

    data = JSON.parse(text);
    console.log(data);


});

