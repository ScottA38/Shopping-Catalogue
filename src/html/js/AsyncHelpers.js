//helper to make a query string from a javascript object
function makeQuery(queryParams)
{
	if(!queryParams)
	{
		return "";
	}
	let queryString = "?";

	Object.keys(queryParams).forEach(function(key)
	{
		if (queryString.slice(-1) != '?')
		{
			queryString = queryString.concat('&');
		}
		queryString = queryString.concat(`${key}=${queryParams[key]}`);
	});
	return queryString;
}

function makePOSTParams(postParams)
{
	let queryString = "";

	Object.keys(postParams).forEach(function(key)
	{
		queryString = queryString.concat(`${key}=${postParams[key]}&`);
	});
	return queryString;
}