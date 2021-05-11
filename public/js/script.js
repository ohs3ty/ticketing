
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

//user page
//view the details within a transaction
function transaction_details() {
    alert("works");
}

// no need currently
// document.getElementsByName('user_organizer')[1].addEventListener("click", function() {
//     document.getElementById('not_user').hidden = false;
// })

// document.getElementsByName('user_organizer')[0].addEventListener("click", function() {
//     document.getElementById('not_user').hidden = true;
// })


// autocomplete (finish this later)
// document.getElementById("organization_name").addEventListener("keyup", function() {
//     var org_input = document.getElementById("organization_name");
//     var org_search = document.getElementById("org_search");

//     document.getElementById("org_search").innerHTML = org_input.value;
// })
