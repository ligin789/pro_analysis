let userId = UserId;
if (userId && WebsiteId) {
  let current_domain = window.location.hostname;
  $.getScript("https://unpkg.com/bowser@2.7.0/es5.js", function () {
    var result = bowser.getParser(window.navigator.userAgent);
    $.getJSON("https://json.geoiplookup.io/?callback=?", function (data) {
      //  //find average time spent on a website
      //  var secondsSpentElement = document.getElementById("seconds-spent");
      //       var millisecondsSpentElement = document.getElementById("milliseconds-spent");
      //     (function () {
      //       "use strict";
      //       requestAnimationFrame(function updateTimeSpent() {
      //         var timeNow = performance.now();
      //         secondsSpentElement.value = round(timeNow / 1000);
      //         millisecondsSpentElement.value = round(timeNow);
      //         requestAnimationFrame(updateTimeSpent);
      //       });
      //       var performance = window.performance, round = Math.round;
      //     })();
      //     console.log(secondsSpentElement);
      //     console.log(millisecondsSpentElement);
      //find width of device and look for user device type
      let deviceWidth = document.documentElement.clientWidth;
      let devicetype;
      if (deviceWidth <= 500) {
        devicetype = "mobile ";
      }
      else if (deviceWidth > 500 && deviceWidth <= 1000) {
        devicetype = "tablet";
      }
      else {
        devicetype = "Personal Computer";
      }
      $.ajax({
        url: "https://proanalysis.000webhostapp.com/server/serverMain.php",
        type: "POST",
        crossDomain: true,
        cors: true,
        // secure: true,
        //             headers: {
        //                 'Access-Control-Allow-Origin': '*',
        //             },
        //   beforeSend: function (xhr) {
        //       xhr.setRequestHeader ("Authorization", "Basic " + btoa(""));
        // },
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
          devicetype: devicetype,
          region: data.region,
          latitude: data.latitude,
          longitude: data.longitude,
        },
        success: function (data, status) {
          console.log("success");
        },
        error: function (responseData, textStatus, errorThrown) {
          console.log(responseData, textStatus, errorThrown);
        }

      });

    });
  });
  //on close event
  window.addEventListener('beforeunload', function (e) {
    e.preventDefault();
    e.returnValue = '';
    logout();
  });
  let logout = function () {
    $.getScript("https://unpkg.com/bowser@2.7.0/es5.js", function () {
      var result = bowser.getParser(window.navigator.userAgent);
      $.getJSON("https://json.geoiplookup.io/?callback=?", function (data) {
        //  //find average time spent on a website
        //  var secondsSpentElement = document.getElementById("seconds-spent");
        //       var millisecondsSpentElement = document.getElementById("milliseconds-spent");
        //     (function () {
        //       "use strict";
        //       requestAnimationFrame(function updateTimeSpent() {
        //         var timeNow = performance.now();
        //         secondsSpentElement.value = round(timeNow / 1000);
        //         millisecondsSpentElement.value = round(timeNow);
        //         requestAnimationFrame(updateTimeSpent);
        //       });
        //       var performance = window.performance, round = Math.round;
        //     })();
        //     console.log(secondsSpentElement);
        //     console.log(millisecondsSpentElement);
        //find width of device and look for user device type
        let deviceWidth = document.documentElement.clientWidth;
        let devicetype;
        if (deviceWidth <= 500) {
          devicetype = "mobile ";
        }
        else if (deviceWidth > 500 && deviceWidth <= 1000) {
          devicetype = "tablet";
        }
        else {
          devicetype = "Personal Computer";
        }
        $.ajax({
          url: "https://proanalysis.000webhostapp.com/server/serverMain.php",
          type: "POST",
          crossDomain: true,
          cors: true,
          // secure: true,
          //             headers: {
          //                 'Access-Control-Allow-Origin': '*',
          //             },
          //   beforeSend: function (xhr) {
          //       xhr.setRequestHeader ("Authorization", "Basic " + btoa(""));
          // },
          dataType: "json",
          data: {
            ValidateData: "logout",
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
            devicetype: devicetype,
            region: data.region,
            latitude: data.latitude,
            longitude: data.longitude,
          },
          success: function (data, status) {
            console.log("success");
          },
          error: function (responseData, textStatus, errorThrown) {
            console.log(responseData, textStatus, errorThrown);
          }

        });

      });
    });
  }
  //on close event ends

}

