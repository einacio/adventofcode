let input = [
'abcdef',
'bababc',
'abbcde',
'abcccd',
'aabcdd',
'abcdee',
'ababab'];

function part1() {
  let count2 = 0,
	count3 = 0;
  for (let x of input) {
	let c = Object.values(x.split('').reduce(function(a, v) {
	  a[v] = (a[v] || 0) + 1;
	  return a;
	}, {}));
	count2 += c.indexOf(2) != -1 ? 1 : 0;
	count3 += c.indexOf(3) != -1 ? 1 : 0;
  }
  return count2 * count3;
}

input = ['abcde',
'fghij',
'klmno',
'pqrst',
'fguij',
'axcye',
'wvxyz']


function part2(){
	let len = input[0].length;
	for (let x of input){
		for (let y of input){
			if (x!==y){
				let l = '', d=0;
				for(let i=0;i<len;i++){
					if(x[i] == y[i]){
						l+=x[i];
					}else{
						d++;
					}
					if(d==2){
						break;
					}
				}
				if(d==1){
					return l;
				}
			}
		}
	}
}