let userId = UserId;
if (userId) {
  let current_domain = window.location.hostname;
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
  //  //find average time spent on a website
  //     (function () {
  //       "use strict";
  //       var secondsSpentElement = document.getElementById("seconds-spent");
  //       var millisecondsSpentElement = document.getElementById("milliseconds-spent");

  //       requestAnimationFrame(function updateTimeSpent() {
  //         var timeNow = performance.now();

  //         secondsSpentElement.value = round(timeNow / 1000);
  //         millisecondsSpentElement.value = round(timeNow);

  //         requestAnimationFrame(updateTimeSpent);
  //       });
  //       var performance = window.performance, round = Math.round;
  //     })();
      //find width of device and look for user device type
      let deviceWidth = document.documentElement.clientWidth;
      let devicetype;
      if (deviceWidth <= 500) {
        devicetype = "mobile";
      }
      else if (deviceWidth > 500 && deviceWidth <= 1024) {
        devicetype = "tablet";
      }
      else {
        devicetype = "pc";
      }


      $.ajax({
        url: "https://proanalysis.000webhostapp.com/server/serverMain.php",
        type: "POST",
        crossDomain: true,
        dataType: "json",
        data: {
          websiteid: WebsiteId,
          userid: UserId,
          browser_name: result.parsedResult.browser.name,
          browser_version: result.parsedResult.browser.version,
          osName: result.parsedResult.os.name,
          ipAddress: data.ip,
          country_name: data.country_name,
          continment: data.continent_name,
          timeZone: data.timezone_name,
          network_provider: data.asn_org,
          currentdomain: current_domain,
          devicetype: devicetype
        },
        success: function (data, status) {
          console.log(data.websiteid);
        },
        error: function (responseData, textStatus, errorThrown) {
          console.log(responseData, textStatus, errorThrown);
        }

      });

    });
  });

}
