//------------------loader-------------


//===============================================



var xml=new XMLHttpRequest();

function stateFun(data){
	xml.open('GET','ajax/state.inc.php?id='+data,'true');
	xml.send();

	xml.onreadystatechange=function(){
		if(xml.readyState==4 && xml.status==200){

			document.getElementById('city').innerHTML=xml.responseText;
		}
	}

} 


function send_message(){ 
	alert("YES");
	var name=jQuery("#name").val();
	var email=jQuery("#email").val();
	var mobile=jQuery("#mobile").val();
	var msg=jQuery("#msg").val();
	if(name=='')	alert('Please enter name');
	else if(email=='')	alert('Please enter email');
	else if(mobile=='')	alert('Please enter mobile no.');
	else if(msg=='')	alert('Please enter message');
	else{
		$.ajax({
			type:'POST',
			url:'/ajax/send_mesasge.php',
			data:{'name':name,'email':email,'mobile':mobile,'msg':msg},
			success:function(data){
				alert(data);
			},
    	
		});
	}

}
	
function manage_cart(id,type){
	var qty=1;
	if(jQuery("#qty").val())
		qty=jQuery("#qty").val();
	xml.open('GET','ajax/manage_cart.php?id='+id+'&type='+type+'&qty='+qty,'true');
	xml.send();

	xml.onreadystatechange=function(){
		if(xml.readyState==4 && xml.status==200){
			//alert(xml.responseText);
			if(xml.responseText=='not_available'){
				alert('Quantity Insufficient');
			}
			else{
			window.location.href=window.location.href;}
		}
	}
	

}

function wishlist(pid,type){
	xml.open('GET','ajax/wishlist_manage.php?id='+pid+'&type='+type,'true');
	xml.send();

	xml.onreadystatechange=function(){
		if(xml.readyState==4 && xml.status==200){
			if(xml.responseText=="not_login"){
				alert("Not login");
			}
			else{
			document.getElementById('wishlist').innerHTML=xml.responseText;
			}
		}
	}
	
}
/* ------------sort product --------*/
function sort_product(cat_id,site_path){
	var x=$('#sort_prod').val();
	window.location.href=site_path+"/categories.php?id="+cat_id+"&sort="+x;
	
}

function login(data){
	xml.open('GET','ajax/login.php?data='+data,'true');
	xml.onreadystatechange=function(){
		if(xml.readyState==4 && xml.status==200){
			document.getElementById('error').innerHTML=xml.responseText;
		}
	}
}



/*-------------checkout-----------------*/
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    // Toggle between adding and removing the "active" class,
    //to highlight the button that controls the panel 
    this.classList.toggle("active");

    //Toggle between hiding and showing the active panel 
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
