function asyncDisplayCards(event)
{
	//remove existing cards from screen
	clearCards();

	let query = "";
	if (event)
	{
		let entityInfo = getCardSetup(event);
		console.assert(entityInfo, "Could not sucessfully get attributes of target to delete!")
		query = makeQuery(entityInfo);
	}

	let xmlhttp = new XMLHttpRequest();
	xmlhttp.onload = function () {
		let htmlBody = document.getElementsByTagName('body')[0];
		let nodes = this.responseXML.body.childNodes;
		console.log(nodes);
		//console.log(this.responseXML.body.outerHTML)
		for(let i = 0; i < nodes.length; i++)
		{
			htmlBody.appendChild(nodes.item(i));
		}
	}

	let asyncAddress = String.prototype.concat("../Generated/ShowAllCards.php", query);
	xmlhttp.open("GET", asyncAddress);
	xmlhttp.responseType = "document";
	xmlhttp.send();
}

function clearCards()
{
	//remove existing card elements from the document
	let cards = document.getElementsByClassName('card');

	while(cards.length > 0)
	{
		cards[0].parentNode.removeChild(cards[0]);
	}
}

function getCardSetup(event)
{
	let target = event.target;
	let obj = {
			action: 'delete'
	};

	while(target.className != "card")
	{
		target = target.parentNode;
		if(target.className == "card-body")
		{
			let bodyChildren = target.children;
			for(let i = 0; i < bodyChildren.length; i++)
			{
				if(bodyChildren.item(i).className == "card-title")
				{
					obj['type'] = bodyChildren.item(i).textContent;
					break;
				}
			}
		} else if (target.tagName == "body"){
			return null;
		}
	}
	if(!target.id) { return null };
	obj['sku'] = target.id;
	return obj;
}