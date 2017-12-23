let a = document.getElementsByTagName('pre')[0].innerText.trim().split("\n"), s = 0;
for(let x of a){
let l = x.split("\t"), mx = Math.max.apply(null, l), mn = Math.min.apply(null, l);
s+= mx-mn;
}
console.log(s);
