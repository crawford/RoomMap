//setInterval("refresh()", 5000);
refresh();

function refresh() {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "getStatus.php", true);
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			parseStatuses(xmlhttp.responseText);
		}
	};
	xmlhttp.send();
}

function parseStatuses(str) {
	var statuses = eval(str);

	occupied = "rgba(255,0,0,0.8)";
	free = "rgba(0,255,0,0.8)";

	document.getElementById("sudsSSeast").style.backgroundColor = (statuses[0] == 0) ? free : occupied;
	document.getElementById("sudsSSwest").style.backgroundColor = (statuses[1] == 0) ? free : occupied;
	document.getElementById("sudsSNeast").style.backgroundColor = (statuses[2] == 0) ? free : occupied;
	document.getElementById("sudsSNwest").style.backgroundColor = (statuses[3] == 0) ? free : occupied;
	document.getElementById("sudsNSeast").style.backgroundColor = (statuses[4] == 0) ? free : occupied;
	document.getElementById("sudsNSwest").style.backgroundColor = (statuses[5] == 0) ? free : occupied;
	document.getElementById("sudsNNeast").style.backgroundColor = (statuses[6] == 0) ? free : occupied;
	document.getElementById("sudsNNwest").style.backgroundColor = (statuses[7] == 0) ? free : occupied;
}
