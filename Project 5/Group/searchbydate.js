function showform(){
    // alert("TEST");
    document.getElementById("addsearchform").style.display = "block";
    document.getElementById("showsearchdate").style.display = "none";
}

function funky(){
    const searchDate = new Date(document.getElementById("searchdate").value);
    // alert("DOC VALUE " + document.getElementById("searchdate").value);
           //erase form from DOM
    document.getElementById("addsearchform").style.display = "none";
    document.getElementById("showsearchdate").style.display = "block";

    // alert("sending new date: " + searchDate + " to calendar");

    const day = searchDate.getDate() + 1;
    const month = searchDate.getMonth();
    const year = searchDate.getFullYear();

    currentDay = day;
    currentMonth = month;
    currentYear = year;
	monthString = monthNames[currentMonth]; //STRING (e.g., "March")
	firstOfMonth = new Date(currentYear, currentMonth, 1).getDay();
	lastOfMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
	fulldate = monthString + " " + currentDay + ", " + currentYear;
	clearCal();
    // console.log("CHECK 0");

	updateCalendar(currentMonth); //set the calendar 

    // console.log("CHECK 1");
    // console.log(fulldate);
    // alert("Day: " + day + " Month: " +  month + " Year: " + year);
}

document.getElementById("showsearchdate").addEventListener("click",showform, false); //displays form to add event
document.getElementById("searchdatebutton").addEventListener("click", funky, false);

document.getElementById("showsearchdate").style.display = "block";
document.getElementById("addsearchform").style.display = "none";
document.getElementById("hidesearchform").addEventListener("click", function(){
    document.getElementById("addsearchform").style.display = "none";
    document.getElementById("showsearchdate").style.display="block";
})