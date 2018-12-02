let a = document.getElementsByTagName('pre')[0].innerText.trim().split("\n"), s = 0;
for(let x of a){
	let l = x.split("\t"), mx = Math.max.apply(null, l), mn = Math.min.apply(null, l);
	s += mx-mn;
}
console.log(s);


//part 2
s = 0;
for(let x of a){
	let l = x.split("\t"), n1, n2, ln = l.length, i, found=0;
	for(let n in l){
		if(n < ln){
			for(i=+n+1;i<=ln;i++){
				n1 = Math.max(l[n], l[i]);
				n2 = Math.min(l[n], l[i]);
				if(n1%n2 == 0){
					s += n1/n2;
					found = 1;
					break;
				}
			}
		}
		if(found){
			break;
		}
	}
}
console.log(s);
