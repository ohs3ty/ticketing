
document.getElementById("start_date").addEventListener("change", function() {
    document.getElementsByName("end_date")[0].value = document.getElementsByName("start_date")[0].value;

})
function getVenues(venues) {

    if (lookup == '') {
        document.getElementById('venue_lookup').innerHTML = "";
    }

    var output = '';
    var lookup = '';
    lookup = document.getElementById("venue").value;
    for (var i = 0; i < venues.length; i++) {
        if (lookup != "") {
            if (venues[i].toUpperCase().search(lookup.toUpperCase()) != -1) {
                output = output + `<div class="autofill" onclick="Autofill('${venues[i]}')" >${venues[i]}</div>`
            }
        }
    }
    document.getElementById('venue_lookup').innerHTML = output;
}

function Autofill(text) {
    document.getElementById("venue").value = text;
    document.getElementById('venue_lookup').innerHTML = "";
}



document.getElementById("new_venue").addEventListener("click", function() {
    if (document.getElementById("new_venue").checked == true) {
        document.getElementById("add_venue").hidden = false;
    } else if (document.getElementById("new_venue").checked == false) {
        document.getElementById("add_venue").hidden = true;
    }
})

// Ticketing
// grey out Quantity box if checkbox is checked
function greyQuantity() {
    if (document.getElementById("unlimited").checked == true) {
        document.getElementById("ticket_limit").value = "";
        document.getElementById("ticket_limit").disabled = true;
    } else if (document.getElementById("unlimited").checked == false) {
        document.getElementById("ticket_limit").disabled = false;
    }

}

//Admin
