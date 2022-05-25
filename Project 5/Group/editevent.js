

{/* <button type = "button" id = "showeditform">Delete an Event</button>
    <form method = "POST" id = "editeventform">
		<button type = "button" id = "hideeditevent">Back</button>
        <input type = "text" id = "edittitle" placeholder = "Event Title To Edit..." required>
        <button type = "button" id = "editevent">Submit</button>

        <script type="text/javascript" src="editevent.js"></script> 

    </form> */}

//     NEW EVENT FORM
//     <form method = "POST" id = "newediteventform">
//     <input type = "text" id = "newedittitle" placeholder = "New Event Title..." required>
//     <button type = "button" id = "neweditevent">Submit</button>
// </form>

function showeditform(){
    document.getElementById("editeventform").style.display = "block";
    document.getElementById("showeditform").style.display = "none";
}

function deleteedit(){
    document.getElementById("editeventform").style.display = "none";
    document.getElementById("showeditform").style.display = "none";

   const title = document.getElementById("edittitle").value;
  // alert("editing " + title + " from the calendar");
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

   document.getElementById("newediteventform").style.display = "block";
}

function replaceedit(){
    document.getElementById("editeventform").style.display = "none";
    document.getElementById("showeditform").style.display = "block";
    document.getElementById("newediteventform").style.display = "none";

    const title = document.getElementById("newedittitle").value;
    const date = new Date(document.getElementById("neweditdate").value);
//    alert("DOC VALUE " + document.getElementById("eventdate").value);
    const time = document.getElementById("newedittime").value;


//    alert("sending " + title + " at " + date + " " + time + " to database");

    const day = date.getDate() + 1;
    const month = date.getMonth();
    const year = date.getFullYear();
    const token = getCookie();
           //send relevant data here
    const data = { 'title': title, 'day': day, 'month' : month,  'year': year, 'time': time, 'token':token };
 //   alert(day + " " + month + " " + year);
            //sending to php page 
           fetch('addevent.php', { //URL for destination php 
                method: "POST",
                body: JSON.stringify(data),
                headers: { 'content-type': 'application/json' }
           })
           //receiving from php page
          .then(response => response.json()) //keep this line the same
          .then(data => (data.success ? (alert(`${data.message}`)): alert(`${data.message}`)))
          //styling above makes the line a bit more complicated... the main purpose is to
          //choose a message depending if the user was successfully logged in or not
          .catch(err => alert((err))); //alert error message
//          alert("about to clear and update cal");
           clearCal();
           updateCalendar();
}
document.getElementById("editeventform").style.display = "none";
document.getElementById("showeditform").addEventListener("click", showeditform, false);

document.getElementById("editevent").addEventListener("click",deleteedit,false);

document.getElementById("hideeditevent").addEventListener("click",function(){
    document.getElementById("editeventform").style.display = "none";
    document.getElementById("showeditform").style.display = "block";
 }, false); 

 document.getElementById("newediteventform").style.display = "none";
 document.getElementById("neweditevent").addEventListener("click", replaceedit, false);
//when editevent is clicked... DELETE OLD EVENT FROM TABLE

//then show a new form (hide the previous form) and INSERT THE EVENT INTO THE TABLE