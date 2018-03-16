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
