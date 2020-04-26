function AjaxFunction()
{
    var httpxml;
    try
    {
        // Firefox, Opera 8.0+, Safari
        httpxml = new XMLHttpRequest();
    }
    catch (e)
    {
        // Internet Explorer
        try
        {
            httpxml = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            try
            {
                httpxml = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e)
            {
                alert("Your browser does not support AJAX!");
                return false;
            }
        }
    }
    
    function stateck() 
    {
        if(httpxml.readyState == 4)
        {
            var myarray = JSON.parse(httpxml.responseText);

            // Remove the old existing options from 2nd dropdown list 
            for(j = document.assign_form.product.options.length - 1; j >= 0; j--)
            {
                document.assign_form.product.remove(j);
            }

            // Add the new selected options to 2nd dropdown list 
            for (i = 0; i < myarray.data.length; i++)
            {
                var optn = document.createElement("OPTION");
                optn.text = myarray.data[i].Name;
                optn.value = myarray.data[i].Product_ID; 
                document.assign_form.product.options.add(optn);
            } 
        }
    }
    
    var url = "select_product.php";
    var cat_id = document.getElementById('s1').value;
    url = url + "?cat_id=" + cat_id;
    url = url + "&sid=" + Math.random();
    httpxml.onreadystatechange = stateck;

    httpxml.open("GET", url, true);
    httpxml.send(null);
}

// function AjaxFunction(choice)
// {
// 	var httpxml;
// 	try
// 	{
// 	// Firefox, Opera 8.0+, Safari
// 		httpxml = new XMLHttpRequest();
// 	}
// 	catch (e)
// 	{
// 		// Internet Explorer
// 		try
// 		{
// 			httpxml = new ActiveXObject("Msxml2.XMLHTTP");
// 		}
// 		catch (e)
// 		{
// 			try
// 			{
// 				httpxml = new ActiveXObject("Microsoft.XMLHTTP");
// 			}
// 			catch (e)
// 			{
// 				alert("Your browser does not support AJAX!");
// 				return false;
// 			}
// 		}
// 	}
		
// 	function stateChanged() 
// 	{
// 		if(httpxml.readyState == 4 && httpxml.status == 200)
// 		{
// 			var myObject = JSON.parse(httpxml.responseText);
            
//             // Remove the old existing options from 2nd dropdown list 
// 			for(j = document.assign_form.product.options.length - 1; j >= 0; j--)
// 			{
// 				document.assign_form.product.remove(j);
// 			}

//             // Add the new selected options to 2nd dropdown list 
// 			var prod_id = myObject.value.product_id;
// 			for (i = 0; i < myObject.products.length; i++)
// 			{
// 				var optn = document.createElement("OPTION");
// 				optn.text = myObject.products[i].Name;
// 				optn.value = myObject.products[i].Product_ID;
// 				document.assign_form.product.options.add(optn);

//                 // If the action taken is selecting a product, keep it selected.
// 				if(optn.value == prod_id)
// 				{
//                     // original is i + 1
// 					document.assign_form.product.options[i].selected = true;
// 				}
// 			} 

//             // Remove the old existing options from 3rd dropdown list 
// 			for(j = document.assign_form.asset.options.length - 1; j >= 0; j--)
// 			{ 
// 				document.assign_form.asset.remove(j);
// 			}

//             // Add the new selected options to 3rd dropdown list
// 			var ass_code = myObject.value.asset_code;
// 			for(i = 0; i < myObject.assets.length; i++)
// 			{
// 				var optn = document.createElement("OPTION");
// 				optn.text = myObject.assets[i].Barcode;
// 				optn.value = myObject.assets[i].Barcode;
// 				document.assign_form.asset.options.add(optn);
                
//                 // If the action taken is selecting an asset, keep it selected.
// 				if(optn.value == ass_code)
// 				{
// 					document.assign_form.asset.options[i].selected = true;
// 				}
// 			} 

// 			//document.getElementById("txtHint").style.background='#00f040';
// 			//document.getElementById("txtHint").innerHTML='done';
// 		}
// 	}

// 	var url = "check_assign.php";
// 	var category_id = assign_form.category.value;
// 	if(choice != 's1')
// 	{
// 		var product_id = assign_form.product.value;
// 		var asset_code = assign_form.asset.value;
// 	}
// 	else
// 	{
// 		var product_id = '';
// 		var asset_code = '';
// 	}
// 	url = url + "?category_id=" + category_id;
// 	url = url + "&product_id=" + product_id;
//     url = url + "&asset_code=" + asset_code;
// 	url = url + "&id=" + Math.random();
// 	assign_form.st.value = product_id;
//     console.log(url);
// 	httpxml.onreadystatechange = stateChanged;

// 	httpxml.open("GET", url, true);
// 	httpxml.send(null);
// }