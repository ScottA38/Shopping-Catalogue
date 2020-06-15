//this function takes an onchange event from drop-down selector
function asyncDisplayForm(event)
{
	//remove existing form from DOM
	clearForm();

	let query = "";

	if (event)
	{
		console.assert(event.target.value);
		query = makeQuery({'type': event.target.value});
	} else {
		let control = document.getElementById('typeSelector');
		query = makeQuery({'type': control.value});
	}

	let xmlhttp = new XMLHttpRequest();
	xmlhttp.onload = function () {
		console.log(this.responseXML);
		let htmlBody = document.getElementsByTagName('body')[0];
		let form = this.responseXML.body.getElementsByTagName('form')[0];
		console.log(form);
		htmlBody.appendChild(form);
	}

	let asyncAddress = String.prototype.concat("../Generated/ProductForm.php", query);
	console.log(asyncAddress);
	xmlhttp.open("GET", asyncAddress);
	xmlhttp.responseType = "document";
	xmlhttp.send();
}

//remove the existing form from the document. Made iterative in case of duplicate form bugs
function clearForm()
{
	let forms = document.getElementsByTagName('form');

	while(forms.length > 0)
	{
		forms[0].parentNode.removeChild(forms[0]);
	}
}