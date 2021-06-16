
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

//Organization
function editDetails(detail) {
    organization_edit = document.getElementsByName('organization_edit');
    organization_input = document.getElementsByName('organization_input');
    if (detail == 'detail') {
        for (var i = 0; i < organization_edit.length; i++) {
            organization_edit[i].hidden = true;
        }
        document.getElementById("detail_pencil").hidden = true;
        document.getElementById("detail_button").hidden = false;
        document.getElementById("detail_cancel").hidden = false;
        document.getElementById("cashnet_input").hidden = false;
        document.getElementById("website_input").hidden = false;
    } else if (detail == 'cancel_detail') {
        for (var i = 0; i < organization_edit.length; i++) {
            organization_edit[i].hidden = false;
        }
        document.getElementById("detail_pencil").hidden = false;
        document.getElementById("detail_button").hidden = true;
        document.getElementById("detail_cancel").hidden = true;
        document.getElementById("cashnet_input").hidden = true;
        document.getElementById("website_input").hidden = true;
    }
}

function addOrganizer(add) {
    if (add == 'add') {
        document.getElementById('add_organizer_div').hidden = false;
        document.getElementById('add_organizer_button').hidden = true;
    } else if (add == 'cancel') {
        document.getElementById('add_organizer_div').hidden = true;
        document.getElementById('add_organizer_button').hidden = false;
    }

}
