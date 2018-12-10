const re = /#(\d+) @ (\d+),(\d+): (\d+)x(\d+)/;

function parse(line){
	const parts = re.exec(line);
	return {
		"id": parts[1],
		"coords": {"x": +parts[2], "y": +parts[3]},
		"size": {"w": +parts[4], "h": +parts[5]}
	};
}

//solves both puzzles
function puzzle(input){
	const input_array = input.trimEnd().split("\n");
	let canvas = [], overlapped={};
	for(let i of input_array){
		let claim = parse(i);
		let y=0, x;
		overlapped[claim.id] = false;
		while(y++ < claim.size.h){
			x = 0;
			while(x++ < claim.size.w){
				if (typeof canvas[claim.coords.x + x] == "undefined"){
					canvas[claim.coords.x + x] = [];
				}
				if (typeof canvas[claim.coords.x + x][claim.coords.y + y] == "undefined"){
					canvas[claim.coords.x + x][claim.coords.y + y] = [];
				}
				canvas[claim.coords.x + x][claim.coords.y + y].push(claim.id);
				if(canvas[claim.coords.x + x][claim.coords.y + y].length > 1){
					for(let id of canvas[claim.coords.x + x][claim.coords.y + y]){
						overlapped[id] = true;
					}
				}
			}
		}
	}
	
	let overlapping_inches = 0;
	for(let a of canvas){
		if(Array.isArray(a)){
			for(let b of a){
				if(Array.isArray(b) && b.length > 1){
					overlapping_inches++;
				}
			}
		}
	}
	let untouched;
	for(let id in overlapped){
		if(overlapped.hasOwnProperty(id) && overlapped[id] === false){
			untouched = id;
			break;
		}
	}
	return [overlapping_inches, untouched];
}
