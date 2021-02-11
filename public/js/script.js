
document.getElementById("end_date").addEventListener("focus", function() {
    document.getElementsByName("end_date")[0].value = document.getElementsByName("start_date")[0].value;
    document.getElementsByName("end_time")[0].value = document.getElementsByName("start_time")[0].value;

})

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