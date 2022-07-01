
function showrepeatform(){
    document.getElementById("repeatEventForm").style.display = "block";
    document.getElementById("showrepeatevent").style.display = "none";
    document.getElementById("addeventform").style.display = "none";
    document.getElementById("showaddevent").style.display = "none";
}

function repeated(){

    const title = document.getElementById("repeateventtitle").value;
    const date = new Date(document.getElementById("repeateventdate").value);
    const time = document.getElementById("repeateventtime").value;

    
    // document.getElementById("repeatEventForm").style.display = "block";
    document.getElementById("repeatEventForm").style.display = "none";
    document.getElementById("showrepeatevent").style.display = "none";
    document.getElementById("showaddevent").style.display = "block";
    
    let day = date.getDate() + 1;
    let month = date.getMonth();
    let year = date.getFullYear();


    if (document.getElementById("repeatDay").checked){

        day = 0;
    } else if (document.getElementById("repeatMonth").checked){

        month = 0;
    } else if (document.getElementById("repeatYear").checked){

        year = 0;
    }

  
    const token = getCookie();
    const data = { 'title':title,'day': day, 'month' : month,  'year': year, 'time': time, 'token':token};
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
          clearCal();
          updateCalendar();
}

document.getElementById("showrepeatevent").addEventListener("click",showrepeatform, false); //displays form to add event
document.getElementById("hideRepeat").addEventListener("click",function(){
       document.getElementById("repeatEventForm").style.display = "none";
       document.getElementById("showrepeatevent").style.display = "block";
       document.getElementById("addeventform").style.display = "block";
    }, false); 
document.getElementById("repeatEventButton").addEventListener("click", repeated, false);
document.getElementById("showrepeatevent").style.display = "none";
document.getElementById("repeatEventForm").style.display = "none";

