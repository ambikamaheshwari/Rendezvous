function verify(){
	  var fname = document.signup.fname;
	    var lname = document.signup.lname;
	    var address = document.signup.address;
	    var city = document.signup.city;
	    var state = document.signup.state;
	    var zip = document.signup.zip;
	    var tel = document.signup.tel;
	    var email = document.signup.email;
	    var password = document.signup.password;
	    var answer1 = document.signup.answer1;
		var answer2 = document.signup.answer2;
		var errmsg="";
	   
	    if((fname.value == "") || (fname.value.length < 3) || (!fname.value.match(/^[A-Za-z]+$/)))
	    {
		  fname.style.background = 'Yellow';
	        errmsg += "You didn't enter a first name or invalid input.\n";
	    }	
		 if((lname.value == "") || (lname.value.length < 3) || (!lname.value.match(/^[A-Za-z]+$/)))
	    {
		  lname.style.background = 'Yellow';
	        errmsg += "You didn't enter a last name or invalid input.\n";
	    }	
		if((address.value == "")|| (address.value.match(/[-!$%^&*()_+|~=`{}[]:@/)))
		{
		    address.style.background = 'Yellow';
	        errmsg += "Invalid address.\n";
		}
		
		if((city.value == "")|| (!city.value.match(/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/)))
		{
		    city.style.background = 'Yellow';
	        errmsg += "Invalid city.\n";
		}
		if((state.value == "")|| (!state.value.match(/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/)))
		{
		    state.style.background = 'Yellow';
	        errmsg += "Invalid state.\n";
		}
		if((zip.value == ""))
		{
		    zip.style.background = 'Yellow';
	        errmsg += "Enter a valid zip code.\n";
		}
		if((tel.value == ""))
		{
		    tel.style.background = 'Yellow';
	        errmsg += "Enter a valid phone number.\n";
		}
		if((email.value == "") || (!email.value.match(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/)))
		{
		    email.style.background = 'Yellow';
	        errmsg += "Invalid email-id.\n";
		}
		if((password.value == "") || (password.value.length < 6))
		{
		    password.style.background = 'Yellow';
	        errmsg += "Password must be atleast 7 characters.\n";
		}
		if(answer1.value == "")
		{
		    answer1.style.background = 'Yellow';
	        errmsg += "Please answer security question:1.\n";
		}
		
		if(answer2.value == "")
		{
		    answer2.style.background = 'Yellow';
	        errmsg += "Please answer security question:2.\n";
		}
		if(answer1.value == answer2.value)
		{
		    answer2.style.background = 'Yellow';
	        errmsg += "Please give different answers for security questions.\n";
		}
		
		if (errmsg.length > 0) {
        //document.signup.innerHTML = "<ul>" + errmsg + "</ul>";
		alert("You must provide the following fields:\n" +errmsg);
        return false;
    }
    return true;
   
	}