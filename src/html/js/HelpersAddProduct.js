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
		document.getElementById('typeSelector')
	}

	let xmlHTTP

}