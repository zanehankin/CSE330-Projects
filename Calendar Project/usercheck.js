function successfunccheck(name) {
document.getElementById("showlogin").style.display = "none";
document.getElementById("showregister").style.display = "none";
document.getElementById("whos").innerHTML = name + "'s Calendar Page";
document.getElementById("whos").style.display = "block";
document.getElementById("showaddevent").style.display = "block";
document.getElementById("addeventform").style.display = "none";
document.getElementById("showeditform").style.display = "block";
document.getElementById("showdeleteform").style.display = "block";
document.getElementById("showsearchdate").style.display = "block";
}

function failurefunc() {
//    alert("No one is logged in");
    document.getElementById("showlogin").style.display = "block";
    document.getElementById("showregister").style.display = "block";
    document.getElementById("logout").style.display = "none";
    document.getElementById("showaddevent").style.display = "none";
    document.getElementById("showeditform").style.display = "none";
    document.getElementById("showdeleteform").style.display = "none";
    document.getElementById("addeventform").style.display = "none";
    document.getElementById("whos").style.display = "none";
   }


fetch('usercheck.php')
.then(response => response.json())
.then(data => (data.success ? ( alert(`${data.message}`), successfunccheck(`${data.name}`)) : (alert(`${data.message}`),failurefunc())))
.catch(err => alert((err)));
