$( document ).ready(function() {
    fetchDailyView();
    fetchCountOFWebsite();
    fetchAllDetails();
    setInterval(fetchDailyView, 30000);
    setInterval(fetchAllDetails, 30000);
});
let fetchDailyView=()=>
{
    $.ajax({
        url: "./server/analysis.php",
        type: "POST",
        dataType: "json",
        data: {
            fetchCountOfUser: "fetchCountOfUser"
        },
        success: function(data, status) {
            $('#dailyCount').text(data.count);
            $('#total_count').text(data.count2);

        },
        error: function (responseData, textStatus, errorThrown) {
            console.log(responseData, textStatus, errorThrown);
          }
    });
}
let fetchCountOFWebsite=()=>{
    $.ajax({
        url: "./server/analysis.php",
        type: "POST",
        data: {
            fetchCountOfWebsite: "fetchCountOfWebsite"
        },
        success: function(data, status) {
            $('#websiteCount').text(data);
        },
        error: function (responseData, textStatus, errorThrown) {
            console.log(responseData, textStatus, errorThrown);
          }
    });
}
let fetchAllDetails=()=>{
    $.ajax({
        url: "./server/analysis.php",
        type: "POST",
        data: {
            fetchAllDetails: "fetchAllDetails"
        },
        success: function(data, status) {
            $('#AllDataFeilds').html(data);
        },
        error: function (responseData, textStatus, errorThrown) {
            console.log(responseData, textStatus, errorThrown);
          }
    });
}
