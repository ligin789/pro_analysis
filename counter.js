let userId = UserId;
if (userId) {
    let current_domain=window.location.hostname;
  $.getScript("https://unpkg.com/bowser@2.7.0/es5.js", function () {
    var result = bowser.getParser(window.navigator.userAgent);
    // document.write(
    //   "You are using " +
    //   result.parsedResult.browser.name +
    //   " v" +
    //   result.parsedResult.browser.version +
    //   " on " +
    //   result.parsedResult.os.name
    // );
    $.getJSON("https://json.geoiplookup.io/?callback=?", function (data) {
      // // console.log(JSON.stringify(data, null, 2));
      // document.write("<br>My Ip address= ", data.ip, "<br>");
      // document.write("My country= ", data.country_name, "<br>");
      // document.write("My Contient_name= ", data.continent_name, "<br>");
      // document.write("My Timezone= ", data.timezone_name, "<br>");
      // document.write("Network provider= ", data.asn_org, "<br>");
        $.ajax({
                    url: "https://proanalysis.000webhostapp.com/server/serverMain.php",
                    type: "POST",
                    crossDomain: true,
                    dataType: "json",
                    data: {
                        websiteid:WebsiteId,
                        userid:UserId,
                        browser_name:result.parsedResult.browser.name ,
                        browser_version:result.parsedResult.browser.version ,
                        osName:result.parsedResult.os.name,
                        ipAddress: data.ip,
                        country_name:data.country_name,
                        continment:data.continent_name,
                        timeZone:data.timezone_name,
                        network_provider:data.asn_org,
                        currentdomain:current_domain
                    },
                    success: function(data, status) {
                        console.log(data.websiteid);
                    },
                    error: function (responseData, textStatus, errorThrown) {
                            console.log(responseData, textStatus, errorThrown);
                   }
                    
                });

    });
  });

}
