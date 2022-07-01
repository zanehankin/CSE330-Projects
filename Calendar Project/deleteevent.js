//asssume on the html side we have a button that has id showdeleteform
// and a form that has a input type = "button" id = "deleteevent" and 
// its larger form is id = deleteeventform
//id = deletetitle is the input type text

function showform(){
    document.getElementById("deleteeventform").style.display = "block";
    document.getElementById("showdeleteform").style.display = "none";
}

function submitdeletion(){
    document.getElementById("deleteeventform").style.display = "none";
    document.getElementById("showdeleteform").style.display = "block";

   const title = document.getElementById("deletetitle").value;
   alert("deleting " + title + " from the calendar");
   const token = getCookie();
   const data = { 'title': title, 'token':token };
    
    fetch('deleteevent.php', {
         method: "POST",
         body: JSON.stringify(data),
         headers: { 'content-type': 'application/json' }
    })
   .then(response => response.json())
   .then(data => (data.success ? alert(`${data.message}`) : alert(`${data.message}`)))
   .catch(err => alert((err)));

   clearCal();
   updateCalendar();
}
document.getElementById("deleteeventform").style.display = "none";
document.getElementById("hidedeleteevent").addEventListener("click",function(){
    document.getElementById("deleteeventform").style.display = "none";
    document.getElementById("showdeleteform").style.display = "block";
 }, false); 
document.getElementById("showdeleteform").addEventListener("click", showform, false);
document.getElementById("deleteevent").addEventListener("click",submitdeletion,false);