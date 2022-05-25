fetch('usercheck.php') //get data from this url
.then(response => response.json())
.then(data => (data.success ? ( alert(`${data.message}`), successfunccheck(`${data.name}`)) : (alert(`${data.message}`),failurefunc())))
.catch(err => alert((err)));
/* ONLY FOR RECIEVING DATA FROM PHP */


data.success ? alert(data.title) : y;

x = function();