function loggedin(name, token){
//  alert(token);
  document.cookie = "token="+ token;
  // alert(document.cookie);
  // alert(getCookie());
  // alert("here");
  document.getElementById("showregister").style.display = "none";
  document.getElementById("logout").style.display = "block";
  document.getElementById("whos").innerHTML = name + "'s Calendar Page";
  document.getElementById("whos").style.display = "block";
  document.getElementById("showaddevent").style.display = "block";
  document.getElementById("showeditform").style.display = "block";
  document.getElementById("showdeleteform").style.display = "block";
  document.getElementById("showsearchdate").style.display = "block";
  clearCal();
  updateCalendar();
}


 function login_ajax(){
   //take the username / password from the form 
   const username = document.getElementById("loginusername").value;
   const password = document.getElementById("loginpassword").value;
      //erase form from DOM
      document.getElementById("loginform").style.display = "none";
      alert("Your username and password have been entered. Logging in....");

      //send relevant data here
      const data = { 'username': username, 'password': password };
      //sending to php page 
      fetch('m5login.php', { //URL for destination php 
           method: "POST",
           body: JSON.stringify(data),
           headers: { 'content-type': 'application/json' }
      })
      //receiving from php page
     .then(response => response.json()) //keep this line the same
     .then(data => (data.success ? (alert("You've been logged in!"),loggedin(username, data.token)): (alert(`You were not logged in: ${data.message}`), document.getElementById("showlogin").style.display = "block")))
     //styling above makes the line a bit more complicated... the main purpose is to
     //choose a message depending if the user was successfully logged in or not
     .catch(err => alert((err))); //alert error message
  }


//This is for show. Just deciding which forms/buttons are seen when
document.getElementById("loginform").style.display = "none";
document.getElementById("showlogin").addEventListener("click", function(){
document.getElementById("showlogin").style.display = "none";
document.getElementById("loginform").style.display = "block";
}, false);     
document.getElementById("hidelogin").addEventListener("click",function(){
  document.getElementById("loginform").style.display = "none";
  document.getElementById("showlogin").style.display = "block";
}, false);
//When login info is submitted go to ajax function THIS IS STEP ONE   
document.getElementById("loginbutton").addEventListener("click",login_ajax, false);


