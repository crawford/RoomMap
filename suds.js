function parseStatus(stall) {
	occupied = "rgba(200,100,100,0.8)";
	free = "rgba(100,200,100,0.8)";

	switch (stall.id) {
		case 1:
			stallDiv = document.getElementById("sudsSSeast");
			break;
		case 2:
			stallDiv = document.getElementById("sudsSSwest");
			break;
		case 3:
			stallDiv = document.getElementById("sudsSNeast");
			break;
		case 4:
			stallDiv = document.getElementById("sudsSNwest");
			break;
		case 5:
			stallDiv = document.getElementById("sudsNSeast");
			break;
		case 6:
			stallDiv = document.getElementById("sudsNSwest");
			break;
		case 7:
			stallDiv = document.getElementById("sudsNNeast");
			break;
		case 8:
			stallDiv = document.getElementById("sudsNNwest");
			break;
		default:
			return;
	}

	if (stall.status == 0) {
		stallDiv.style.backgroundColor = free;
	} else {
		stallDiv.style.backgroundColor = occupied;
	}
}

function parseStatuses(stalls) {
	for (stall in stalls.north) {
		parseStatus(stalls.north[stall]);
	}
	for (stall in stalls.south) {
		parseStatus(stalls.south[stall]);
	}
}


//Adapted from ComputerScienceHouse/SUDS
//Originally written by Sean McGary
window.onload = function() {
	var socket = new io.Socket(null, {port: 8888, secure: false, rememberTransport: false});
	socket.connect();

	socket.on('message', function(obj)
	{
		console.log(obj);
		switch(obj.opcode) {
			case "data_init":
			case "stall_dump":
				parseStatuses(obj['stalls']);
				break;
			case "update_stall":
				parseStatus(obj);
				break;
			default:
				break;
		}
	});

	socket.on('connect', function()
	{
		console.log('connected');
	});

	socket.on('disconnect', function()
	{
		console.log("disconnected");
	});

	socket.on('reconnect', function()
	{
		console.log("reconnected");
	});

	socket.on('reconnecting', function( nextRetry )
	{
		console.log("reconnecting");
	});

	socket.on('reconnect_failed', function()
	{
		console.log("failed to reconnect");
	});
};
