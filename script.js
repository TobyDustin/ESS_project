function addProperty(ident) {
    var e = document.getElementById("addNewProperty");
    e.style.fontSize= "12pt";
    e.innerHTML = "Add Property <br /><form action='Customer_Dashboard.php' method='post'>\n" +
        "<input type='text' name='id' placeholder='Postcode' value='"+ident+"' style='width:100%' hidden><br />\n" +
        "<input type='text' name='postcode' placeholder='Postcode' style='width:100%'><br />\n" +
        "<input type='text' name='address' placeholder='Address' style='width:100%'><br />\n" +
        "<input type='text' name='town' placeholder='Town' style='width:100%'><br />\n" +
        "<input type='text' name='county' placeholder='County' style='width:100%'><br />\n" +
        "<input type='submit' name='sub' value='Add Property' style='width:100%'><br />\n" +
        "</form>";
}

var s;
function changeStarColor(style, i) {
    s = style;
    i.style.color = '#f9c22f';

}
function changeBack(i){

    i.style.color = s;
}

 //   ratingClicked($client_id,this.id,$staff)



function ratingClicked(client,rating,staff) {
    console.log(client+" client.");
    console.log(staff+" staff.");
    console.log(rating+" rate.");
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

        }
    };
    xmlhttp.open("GET", "ratingAJAX.php?c="+client+"&s="+staff+"&r="+rating, true);

    xmlhttp.send();

}



function show_preference() {

}


function change_preference(pref,value) {
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

        }
    };
    xmlhttp.open("GET", "ratingAJAX.php?c="+client+"&s="+staff+"&r="+rating, true);

    xmlhttp.send();

}

function addService(id) {
    document.getElementById('edt_staffADD').value=id;
}

