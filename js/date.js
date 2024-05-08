// Function to update the current date and time
function updateTime() {
    var date = new Date();
    var dateString = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
    
    document.getElementById("date").innerHTML = "Data: " + dateString;

    setTimeout(updateTime, 1000); // Update every second
}

updateTime(); // Call the function to start updating the time