let cards = document.getElementsByClassName('card');

for(let i = 0; i < cards.length; i++)
{
	document.remove();
}

let xmlhttp = new XMLHttpRequest();
xmlhttp.onload = function () {
	let htmlBody = document.getElementsByTagName('body')[0];
	let nodes = this.responseXML.body.childNodes;
	console.log(nodes);
	for(let i = 0; i < nodes.length; i++)
	{
		htmlBody.after(nodes.item(i));
	}
}
xmlhttp.open("GET", "../Generated/ShowAllCards.php");
xmlhttp.responseType = "document";
xmlhttp.send();