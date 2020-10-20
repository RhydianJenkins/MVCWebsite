function init_map(){
    var options = {
        zoom: 12,
        center: new google.maps.LatLng(51.5489492,-3.7385435999999572),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false
    };
    map = new google.maps.Map(document.getElementById("gmap_canvas"), options);
    marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(51.5489492, -3.7385435999999572)});
    //infowindow = new google.maps.InfoWindow({content:"<b>Tata Steel Sailing Club</b><br/>Eglwys Nunydd Reservoir<br/>SA13 2NS Port Talbot" });
    google.maps.event.addListener(marker, "click", function(){infowindow.open(map,marker);});
    //infowindow.open(map, marker);
}
google.maps.event.addDomListener(window, 'load', init_map);