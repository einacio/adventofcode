//read the number from the page
let a = document.getElementsByTagName('pre')[0].innerText.trim().split('');
//number is "circular", last number compares with first
a.push(a[0]);
console.log((a.reduce(function(d, c){if(d.prev == c)d.sum+=parseInt(c);d.prev=c;return d;}, {prev:'',sum:0})).sum);
