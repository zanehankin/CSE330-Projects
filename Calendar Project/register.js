//if isset $_SESSION[user] 
//then document.getElementById("registerform").style.display = "none";
//and nothing else 

function registered(){
   document.getElementById("showlogin").style.display = "block";
   document.getElementById("logout").style.display = "none";
 //  document.getElementById("whos").innerHTML = name + "'s calendar";
   document.getElementById("whos").style.display = "none";
   document.getElementById("showaddevent").style.display = "none";
   alert("You've been registered!");
   // clearCal();
   // updateCalendar();
}

function register_ajax(){

    //erase form from DOM
 const username = document.getElementById("regusername").value;
 const password = document.getElementById("regpassword").value;
 alert("Registering a new user: " + username);   
 document.getElementById("registerform").remove();
   

    //send data here
    const data = { 'username': username, 'password': password };
    
    fetch('m5register.php', {
         method: "POST",
         body: JSON.stringify(data),
         headers: { 'content-type': 'application/json' }
    })
   .then(response => response.json())
   .then(data => (data.success ? (registered()) : alert(`You were not registered: ${data.message}`)))
   .catch(err => alert((err)));

}

document.getElementById("registerform").style.display = "none";
document.getElementById("showregister").addEventListener("click", function(){
    document.getElementById("showregister").style.display = "none";
    document.getElementById("registerform").style.display = "block";
   }, false);   
document.getElementById("hideregister").addEventListener("click",function(){
   document.getElementById("registerform").style.display = "none";
   document.getElementById("showregister").style.display = "block";
}, false);
document.getElementById("registerbutton").addEventListener("click",register_ajax, false);

   