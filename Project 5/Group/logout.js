
function successfunc() {
    document.getElementById("showlogin").style.display = "block";
    document.getElementById("showregister").style.display = "block";
 //   document.getElementById("whos").innerHTML = name + "'s calendar page";
    document.getElementById("logout").style.display = "none";
    document.getElementById("whos").style.display = "none";
    document.getElementById("showaddevent").style.display = "none";
    document.getElementById("showeditform").style.display = "none";
    document.getElementById("showdeleteform").style.display = "none";
    document.cookie = "token= ";
    clearCal();
    updateCalendar();
}
    

    
// function logout_ajax(){
//     alert("here")
//     fetch('logout.php')
//     .then(response => response.json())
//     .then(data => (data.success ? ( alert(`${data.message}`), successfunc()) : (alert(`${data.message}`))))
//     .catch(err => alert((err)));
// }

//document.getElementById("logout").addEventListener("click",logout_ajax(),false);
document.getElementById("logout").addEventListener("click",function(){
    const token = getCookie();
    const data = {'token': token};
    fetch('logout.php',{
      method: "POST",
      body: JSON.stringify(data),
      headers: { 'content-type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => (data.success ? (alert(`${data.message}`), successfunc()) : (`${data.message}`)))
  //  then(data => alert((data.success ? ("You've been logged in!", loggedin()): `You were not logged in: ${data.message}`)))
    .catch(err => alert((err)));
},false);
    