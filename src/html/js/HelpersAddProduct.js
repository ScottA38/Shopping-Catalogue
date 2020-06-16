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

//function to fire when user submits form
function onSubmit()
{
	let setupObj = getFormSetup();
	let postString = "";
	if (setupObj)
	{
		postString = makePOSTParams(setupObj);
		console.log(`Sending postString of ${postString}`);
	} else {
		return false;
	}

	let xmlhttp = new XMLHttpRequest();
	xmlhttp.onload = function() {
		console.log(this.responseXML.body.outerHTML);
		let message = this.responseXML.body.getElementById('responseMessage');
		document.body.insertBefore(document.body.firstChild.nextSibling, message);
	}
	xmlhttp.open("POST", "../Generated/AddProduct.php");
	xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xmlhttp.responseType = "document";
	xmlhttp.send(postString);
}

function getFormSetup()
{
	let properties = {
			type: document.getElementById('typeSelector').value,
	};
	//assumed only one form on the page, otherwise this would cause issues
	let form = document.getElementsByTagName('form')[0];
	let inputs = form.getElementsByTagName('input');
	for (let i = 0; i < inputs.length; i++)
	{
		let input = inputs[i];
		if (!input.value) { alert(`No value entered for ${input.name}`); return null; }

		if (input.name != 'name' && input.name != 'price')
		{
			//detecting whether input form field is formatted as an array
			let arrMatch = input.name.match(/\[\d+\]/);
			if(arrMatch)
			{
				if (properties['special']) {
					properties['special'][arrMatch[1]] = input.value;
				} else {
					properties['special'] = [input.value];
				}
			} else {
				properties['special'] = input.value;
			}
		} else
		{
			properties[input.name] = input.value;
		}
	}
	return properties
}