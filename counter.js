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
          latitude:data.latitude,
          longitude:data.longitude,
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

// INSERT INTO `tbl_data`(`data_id`, `data_user_id`, `data_website_id`, `data_Contient_name`, `data_ip`, `os_name`, `data_browser`, `data_device_type`, `data_country`, `data_browser_version`, `data_region`, `data_latitude`, `data_longitude`, `data_timezone`, `data_timeSpend`, `data_created_at`, `data_network_provider`, `data_status`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14],[value-15],[value-16],[value-17],[value-18])