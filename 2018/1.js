let a = [1,-2,3,1];

function part1(){
	let c = 0, e={};
	for(let x of a){
		c+=x;
	}
	return c;
};

function part2(){
	let c = 0, e={};
	while(1){
		for(let x of a){
			c+=x;
			if(!e[c]){
				e[c]=1;
			}else{
				return c;
			}
		}
	}
};
