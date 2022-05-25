
function showform(){
    document.getElementById("addeventform").style.display = "block";
    document.getElementById("showaddevent").style.display = "none";
    document.getElementById("showrepeatevent").style.display = "block";
}

function funky(){
    const title = document.getElementById("eventtitle").value;
    const date = new Date(document.getElementById("eventdate").value);
    const time = document.getElementById("eventtime").value;
           //erase form from DOM
    document.getElementById("addeventform").style.display = "none";
    document.getElementById("showaddevent").style.display = "block";

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
          clearCal();
           updateCalendar();
}

document.getElementById("showaddevent").addEventListener("click",showform, false); //displays form to add event
document.getElementById("hideaddevent").addEventListener("click",function(){
       document.getElementById("addeventform").style.display = "none";
       document.getElementById("showaddevent").style.display = "block";
       document.getElementById("showrepeatevent").style.display = "none";
    }, false); 
document.getElementById("addeventbutton").addEventListener("click", funky, false);

