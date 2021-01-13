/**************************
 * SIT203 Web Programming
 * Assignment 1
 * Aaron Pethybridge
 * Student#: 217561644
 * Javascript file
 **************************/

 // Global variable
var displayNumber = 6; // number of products displayed on page
var CatalogXMLRequest;
var catalogData, furnitureData, accessoriesData; // storage variables for catalog, furniture and accessories data
var searchResults; // Holder for products to be be displayed on the screen
var furnitureSearchResults, accessoriesSearchResults, unfilteredSearchResults = ""; 
var numPages = 1; // Stores number of pages required to display results
var currentPage = 1; // Number of page to be currently displayed
var start, end; // start = first value of items being displayed - end = final value of items being displayed
var totalResults, totalFurnitureProducts = 0, totalAccessoriesProducts = 0; // Various totals holders
var brandFilterString = ""; // String containing names of brands selected in filters box
var brandsArray = ["Universal", "Ikea", "The Factory", "Fantastic", "Artdeco"];
var numBrands = 5;
var renderedFiltersPanel = false; // Flag for deciding if filters panel is already rendered
var selectedProduct = ""; // Holder for product to display on detail page
var onDetailsPage = false; // Flag to decide if details page is the current page
var selectedSubtype = "";
var xhttp; // HTTP object

function submitUpdateForm(action)
{
	document.getElementById('basketForm').action = action;
	document.getElementById('basketForm').submit();
}

function showResult(searchHint)
{
	if (searchHint.length == 0)
	{
		document.getElementById("suggestions").innerHTML = "";
		document.getElementById("suggestions").style.border = "0px";
		return;
	}
	document.getElementById("suggestions").style.visibility = "visible";
	
	if (window.XMLHttpRequest) // code for IE7+, Firefox, Chrome, Opera, Safari
	{
		xmlhttp = new XMLHttpRequest();
	}
	else // code for IE6, IE5
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById("suggestions").innerHTML = xmlhttp.responseText;
			document.getElementById("suggestions").style.border = "1px solid #000000";
		}
	}
	xmlhttp.open("GET","searchsuggest.php?q=" + searchHint, true);
	xmlhttp.send();
}

function hideSuggestions()
{
	document.getElementById("suggestions").style.visibility = "hidden";
}

// Loads Catalog XML file
function loadCatalogXML(productRange)
{
	try
	{
		CatalogXMLRequest = new XMLHttpRequest();

		// register event handler
		/*CatalogXMLRequest.onreadystatechange = function()
		{
			getCatalogData(productRange); 
		}; */
		CatalogXMLRequest.open( 'GET', 'catalog.xml', false ); 
		CatalogXMLRequest.send(""); 
	} // end try
	catch ( exception )
	{
		alert("An error has occured loading the data. Please reload the page");
	} // end catch
	getCatalogData(productRange);

}

// Obtains data from catalog XML file
function getCatalogData(inProductRange)
{
	//if (CatalogXMLRequest.readyState == 4 && 
    //    CatalogXMLRequest.status == 200 && CatalogXMLRequest.responseXML )
    //{ 
	catalogData = CatalogXMLRequest.responseXML;
	getAllProducts();
	createResultsArray(inProductRange);
	calculateNumPages(totalResults);
	selectedSubtype = "";
	displayBrandFiltersPanel();
		renderedFiltersPanel = true;
	if (!onDetailsPage)
		renderCatalogProducts();
	
	//}
}

// Create furniture and accessories data from XML data
function getAllProducts()
{
	var numFurniture = 0, numAccessories = 0;
	var results = catalogData.getElementsByTagName("catalogproduct");
	var totalResults = results.length;
	
	for (var i = 0; i < results.length; i++)
	{
		if (results[i].getAttribute("type") == "furniture")
			numFurniture++;
		else	
			numAccessories++;
	}
	furnitureData = getProductRangeData("furniture", numFurniture, results, totalResults);
	totalFurnitureProducts = furnitureData.length;
	accessoriesData = getProductRangeData("accessories", numAccessories, results, totalResults);
	totalAccessoriesProducts = accessoriesData.length;
}

// Obtain specific product range data from overall catalog data
function getProductRangeData(inRange, num, inResults, inTotalResults)
{
	var rangeResults = new Array(num);
	var result;
	var index = 0;
	
	for (var i = 0; i < inTotalResults; i++)
	{
		if (inResults[i].getAttribute("type") == inRange)
		{
			rangeResults[index] = inResults[i];
			index++;
		}
	}
	return rangeResults
}

// Assigns either furniture or accessories data to "searchResults" array
// Allows use of js Array functionality to access product "node" elements
function createResultsArray(inRange)
{
	if (inRange == "furniture")
		searchResults = furnitureData;
	else	
		searchResults = accessoriesData;
	totalResults = searchResults.length;
	if (displayNumber > totalResults)
		switchDisplayNumber(totalResults);
}

// Displays summary information for all relevant products 
function renderCatalogProducts()
{
	var image1, image2, product, price, id, ctype;
	var output = "";
		
	onDetailsPage = false;
	if (totalResults > 0)
	{
		start = (currentPage - 1) * displayNumber;
		end = start + displayNumber;
		/*
		if ((totalResults < start + displayNumber) && currentPage == 1)
			end = totalResults;
		else
			end = start + displayNumber;*/
		if (end > totalResults)
			end = totalResults;
				
		for (var i = start; i < end; i++)
		{
			ctype = searchResults[i].getAttribute("type");
			id = searchResults[i].getAttribute("id");
			image1 = searchResults[i].getElementsByTagName("imageone")[0].firstChild.nodeValue;
			image2 = searchResults[i].getElementsByTagName("imagetwo")[0].firstChild.nodeValue;
			product = searchResults[i].getElementsByTagName("product")[0].firstChild.nodeValue;
			price = searchResults[i].getElementsByTagName("price")[0].firstChild.nodeValue;
			
			output += '<div class="col-md-4 col-sm-6">';
			output += '<div class="product">';
			output += '<div class="flip-container">';
			output += '<div class="flipper">';
			output += '<div class="front">';
			output += '<a href="detail.php?id=' + id + '&ctype=' + ctype + '">';
			output += '<img src="img/' + image1 + '" alt="' + product + '" class="img-responsive" />';
			output += '</a>';
			output += '</div>';
			output += '<div class="back">';
			output += '<a href="detail.php?id=' + id + '&ctype=' + ctype + '">';
			output += '<img src="img/' + image2 + '" alt="' + product + '" class="img-responsive" />';
			output += '</a>';
			output += '</div>';
			output += '</div>';
			output += '</div>';
			output += '<a href="detail.php" class="invisible">';
			output += '<img src="img/product1.jpg" alt="' + product + '" class="img-responsive" />';
			output += '</a>';
			output += '<div class="text">';
			output += '<h3>';
			output += '<a href="detail.php?id=' + id + '&ctype=' + ctype + '">' + product + '</a>';
			output += '</h3>';
			output += '<p class="price">$' + price + '</p>';
			output += '<p class="buttons">';
			output += '<a href="detail.php?id=' + id + '&ctype=' + ctype + '" class="btn btn-default">View detail</a>';
			output += '<a href="basket.php?action=add&id=' + id + '" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a>';
			output += '</p>';
			output += '</div>';
			output += '</div>';
			output += '</div>';
			//output += '</td>';
			//if (i % 3 == 2)
				//output += '</tr>';
		}
		//output += '</table>';
		document.getElementById("displayAllProducts").innerHTML = output;
	}
	else
	{
		document.getElementById("displayAllProducts").innerHTML = '<h4 style="text-align: center;">No results found. Please try selecting a different brand.</h4>';
	}
	displayTotalRange("totalFurniture", totalFurnitureProducts);
	displayTotalRange("totalAccessories", totalAccessoriesProducts);
	if (!renderedFiltersPanel)// || selectedSubtype == "")
	{
		displayBrandFiltersPanel();
		renderedFiltersPanel = true;
	}
	displaySwitchDisplayNumber()
	displayResultsTotals();
	renderPagination();
}

// Calculates how many required to "hold" search results
function calculateNumPages(numSearchResults)
{
	numPages = Math.ceil(numSearchResults / displayNumber);
	//alert(numPages);
}

// Renders information and controls for switching how many items display on screen
function displaySwitchDisplayNumber()
{
	var doutput = "";
	doutput += '<strong>Show</strong>';
	doutput += '<a onclick="switchDisplayNumber(6)" href="#" class="btn btn-default btn-sm';
	if (displayNumber == 6)
		doutput += ' btn-primary';
	doutput += '">6</a>';
	doutput += '<a onclick="switchDisplayNumber(12)" href="#" class="btn btn-default btn-sm';
	if (displayNumber == 12)
		doutput += ' btn-primary';
	doutput += '">12</a>';
	doutput += '<a onclick="switchDisplayNumber(totalResults)" href="#" class="btn btn-default btn-sm';
	if (displayNumber == totalResults)
		doutput += ' btn-primary';
	doutput += '">All</a> products';
	document.getElementById("switchNumbers").innerHTML = doutput;
}

// Displays furniture and accessories totals in sidebar
function displayRangeTotals()
{
	loadCatalogXML("furniture")
	displayTotalRange("totalFurniture", totalFurnitureProducts);
	displayTotalRange("totalAccessories", totalAccessoriesProducts);
	displayBrandFiltersPanel();
}

// Displays how many of either furniture or accessories products have been read from catalog XML file
function displayTotalRange(inTotalDiv, inTotal)
{
	document.getElementById(inTotalDiv).innerHTML = inTotal;
}

// Update screen when change made to number of items to display
function switchDisplayNumber(num)
{
	displayNumber = num;
	calculateNumPages(totalResults);
	currentPage = 1;
	renderCatalogProducts();
}

// Displays totals for "Showing X - Y of Z products" screen area
function displayResultsTotals()
{
	var startPage = start + 1;
	var	endPage = end;
	if (totalResults == 0)
	{
		startPage = 0; endPage = 0;
	}
	document.getElementById("startNum").innerHTML = startPage;
	document.getElementById("endNum").innerHTML = endPage;
	document.getElementById("totalNumResults").innerHTML = totalResults;
}

// Displays pagination controls
function renderPagination()
{
	var pageOutput = "";
	
	pageOutput += '<ul class="pagination">';
	pageOutput += '<li>';
	if (currentPage > 1)
		pageOutput += '<a onclick="switchPageNumber(' + (currentPage - 1) + ')" href="#">&laquo;</a>';
	pageOutput += '</li>';
	for (var i = 0; i < numPages; i++)
	{
		if (i + 1 == currentPage)
			pageOutput += '<li class="active"><a href="#">' + (i + 1) + '</a>';
		else
			pageOutput += '<li><a onclick="switchPageNumber(' + (i + 1) + ')" href="#">' + (i + 1) + '</a>';
		pageOutput += '</li>';
	}
	pageOutput += '<li>';
	if (currentPage < numPages)
		pageOutput += '<a onclick="switchPageNumber(' + (currentPage + 1) + ')" href="#">&raquo;</a>';
	pageOutput += '</li>';
	pageOutput += '</ul>';
	document.getElementById("displayPagination").innerHTML = pageOutput;
}

// Update page display to new selected page
function switchPageNumber(newPage)
{
	currentPage = newPage;
	renderCatalogProducts();
}

// Displays products sorted by price (ascending or descending)
function sortProducts(sortOrder)
{
	// Selection sort algorithm
	var iValue, jValue, minValue, temp;
	
	for (var i = 0; i < totalResults; i++ )
	{
		var min = i;
		for (var j = i + 1; j < totalResults; j++ )
		{
			jValue = searchResults[j].getElementsByTagName("price")[0].firstChild.nodeValue;
			minValue = searchResults[min].getElementsByTagName("price")[0].firstChild.nodeValue;
			if (sortOrder == 'asc')
			{
				if (parseInt(jValue) < parseInt(minValue))
					min = j;
			}
			else
			{
				if (parseInt(jValue) > parseInt(minValue))
					min = j;
			}			
		}
		if ( min != i )
		{
			temp = searchResults[i];
			searchResults[i] = searchResults[min];
			searchResults[min] = temp;
		}
	}
	renderCatalogProducts();
}

// Displays items on screen that are of "productType" subtype
function displayProductType(productType, inRange)
{
	var newResults = new Array();
	var newIndex = 0;
	var subtype;
	
	clearBrandFilters();
	selectedSubtype = productType;
	createResultsArray(inRange);
	for (var i = 0; i < totalResults; i++ )
	{
		subtype = searchResults[i].getElementsByTagName("subtype")[0].firstChild.nodeValue;
		if (subtype == productType)
		{
			newResults[newIndex++] = searchResults[i];
			//newIndex++;
		}
	}
	searchResults = newResults;
	totalResults = searchResults.length;
	calculateNumPages(totalResults);
	currentPage = 1;
	renderCatalogProducts();
	displayBrandFiltersPanel();
}

// Displays brand filters details panels
function displayBrandFiltersPanel()
{
	var poutput = "";
	
	poutput += '<form>';
	poutput += '<div class="form-group">';
	poutput += '<div class="checkbox">';
	poutput += '<label>';
	poutput += '<input id="filterBrand1" type="checkbox" />Universal (' + displayfilterBrandNumber("Universal") + ')';
	poutput += '</label>';
	poutput += '</div>';
	poutput += '<div class="checkbox">';
	poutput += '<label>';
	poutput += '<input id="filterBrand2" type="checkbox" />Ikea (' + displayfilterBrandNumber("Ikea") + ')';
	poutput += '</label>';
	poutput += '</div>';
	poutput += '<div class="checkbox">';
	poutput += '<label>';
	poutput += '<input id="filterBrand3" type="checkbox" />The factory (' + displayfilterBrandNumber("The Factory") + ')';
	poutput += '</label>';
	poutput += '</div>';
	poutput += '<div class="checkbox">';
	poutput += '<label>';
	poutput += '<input id="filterBrand4" type="checkbox" />Fantastic (' + displayfilterBrandNumber("Fantastic") + ')';
	poutput += '</label>';
	poutput += '</div>';
	poutput += '<div class="checkbox">';
	poutput += '<label>';
	poutput += '<input id="filterBrand5" type="checkbox" />Artdeco (' + displayfilterBrandNumber("Artdeco") + ')';
	poutput += '</label>';
	poutput += '</div>';
	poutput += '</div>';
	poutput += '<button type="button" onclick="filterBrand()" class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Apply</button>';
	poutput += '</form>';
	document.getElementById("filtersPanel").innerHTML = poutput;
}

// Returns total number of products of a particular brand within furniture or accessories for display
function displayfilterBrandNumber(inBrand)
{
	var numBrand = 0;
	
	//alert(totalResults + " Brnd: " + inBrand);
	//alert(selectedSubtype);
	for (var i = 0; i < totalResults; i++ )
	{
		if (searchResults[i].getElementsByTagName("brand")[0].firstChild.nodeValue == inBrand)
		{
			//alert("WWW");
			/*
			if (selectedSubtype != "")
			{
				//alert("FFF");
				if (selectedSubtype == searchResults[i].getElementsByTagName("subtype")[0].firstChild.nodeValue)
					numBrand++;
			}
			else
			{
				numBrand++;
			}*/
			numBrand++;
		}
			//numBrand++;
			//filterBySubtype(searchResults[i]);
	}
	//alert(numBrand);
	return numBrand;
}

function filterBySubtype(inProduct)
{
	//alert(inProduct.getElementsByTagName("subtype")[0].firstChild.nodeValue);
	
}

// Adjust search results based on checked filters
function filterBrand()
{
	brandFilterString = "";
	for (var i = 0; i < numBrands; i++)
	{
		var bnum = i + 1;
		var filter = "filterBrand" + bnum.toString();
		if (document.getElementById(filter).checked)
			brandFilterString += brandsArray[i];
	}
	if (brandFilterString != "")
	{
		unfilteredSearchResults = searchResults;
		filterResultsByBrand();
	}
	else
	{
		if (unfilteredSearchResults != "")
			searchResults = unfilteredSearchResults;
		totalResults = searchResults.length;
		calculateNumPages(totalResults);
		currentPage = 1;
		renderCatalogProducts();
	}
}

// Creates actual results of filtering by brand
function filterResultsByBrand()
{
	var newResults = new Array();
	var newIndex = 0;
	
	for (var i = 0; i < searchResults.length; i++)
	{
		currentProductBrand = searchResults[i].getElementsByTagName("brand")[0].firstChild.nodeValue;
		if (brandFilterString.indexOf(currentProductBrand) != -1) // if current brand is within filter string
		{
			newResults[newIndex] = searchResults[i];
			newIndex++;
		}
	}
	searchResults = newResults;
	totalResults = searchResults.length;
	calculateNumPages(totalResults);
	currentPage = 1;
	renderCatalogProducts();
	searchResults = unfilteredSearchResults;
}

// Unchecks all brand filter boxes
function clearBrandFilters()
{
	for (var i = 0; i < numBrands; i++)
	{
		var bnum = i + 1;
		var filter = "filterBrand" + bnum.toString();
		document.getElementById(filter).checked = false;
	}
}

// Obtains from the URL id and subtype of product whose details will be displayed 
function getSelectedProduct()
{
	onDetailsPage = true;
	var url = document.URL;
	var queryString = url.substring( url.indexOf('?') + 1 );
	var idString = queryString.substring(0, queryString.indexOf('&'));
	var id = parseInt(idString.substring(idString.indexOf('=') + 1));
	var ctypeString = queryString.substring(queryString.indexOf('&') + 1);
	var ctype = ctypeString.substring(ctypeString.indexOf('=') + 1);

	displayRangeTotals();
	displaySelectedProduct(id, ctype);
}

// Utility function to load and return data from a specified XML/XSL file
function loadXMLDoc(filename)
{
	if (window.ActiveXObject)
	{
		xhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	else
	{
		xhttp = new XMLHttpRequest();
	}
	xhttp.open("GET", filename, false);
	try {xhttp.responseType = "msxml-document"} catch(err) {} // Helping IE11
	xhttp.send("");
	return xhttp.responseXML;
}

// Render selected product details to the screen using XML data and XSL stylesheet
function displaySelectedProduct(productId, range)
{
	var xml = loadXMLDoc("catalog.xml");
	//alert(xml.nodeName);
	var xsl = loadXMLDoc("detail.xsl");
	//alert(xsl);
	
	// code for IE
	// NB. Despite a long effort, I was unable to get this code to work on IE11
	if (window.ActiveXObject || xhttp.responseType == "msxml-document")
	{
		var xslt = new ActiveXObject("Msxml2.XSLTemplate");
		var xslDoc = new ActiveXObject("Msxml2.FreeThreadedDOMDocument");
		xslDoc.loadXML(xsl.xml);
		xslt.stylesheet = xslDoc;
		var xslProc = xslt.createProcessor();
		xslProc.input = xml;
		xslProc.transform();

		document.getElementById("detailsDisplay").innerHTML = xslProc.output;
	}

	// code for Chrome, Firefox, Opera, etc.
	else if (document.implementation && document.implementation.createDocument)
	{
		var xsltProcessor = new XSLTProcessor();
		xsltProcessor.importStylesheet(xsl);
		xsltProcessor.setParameter(null, "productId", productId);
		xsltProcessor.setParameter(null, "range", range);
		var resultFragment = xsltProcessor.transformToFragment(xml, document);
		document.getElementById("detailsDisplay").appendChild(resultFragment);
	}
}