$('document').ready(function() {
    onPageLoad();
})

var key = CryptoJS.enc.Hex.parse("0123456789cdec0123456789cdeccdec");
var iv =  CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

setInterval(function() {
    var s_id = $('#sessionCheck').html();
    let hashId = CryptoJS.AES.encrypt(s_id, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

    $.ajax({
        url: "check_session.php",
        type: "POST",
        data: {session: hashId},
        success: function(data) {
            if(data == "destroy") {
                window.alert("You are already logged in somewhere.");
                window.location.href = "logout.php";
            } else {
                $('#fullContainer').load("dashboard.php #innerDiv", function() {
                    // $('#showLeaderboard').load("dashboard.php #leaderBoard");
                    onPageLoad();
                });
            }
        },
        error: function(error) {
            console.log(error.responseText);
        }
    })
}, 120000); 

function onPageLoad() {

    var AmaleCount = $('#amales').val()
    var AfemaleCount = $('#afemales').val();

    var chartData3 = {
        labels  : ["Female", "Male"],
        datasets: [
            {
                label               : 'Gender Vs Participants',
                backgroundColor     : ["#FF2974", "#3BD9C8"],
                data                : [AfemaleCount, AmaleCount]
            }
        ]
    }

    //------------------
    //- DOUGHNUT CHART -
    //------------------

    var doughnutChartCanvas = $('#gendervsparticipants').get(0).getContext('2d');
    var doughnutChartData = $.extend(true, {}, chartData3)
    var temp0 = chartData3.datasets[0]
    doughnutChartData.datasets[0] = temp0

    var doughnutChartOptions =  {
        responsive: true
    };

    var doughnutChart = new Chart(doughnutChartCanvas, {
        type: 'doughnut',
        data: doughnutChartData,
        options: doughnutChartOptions
    })

    var userCount = [];
    $.each($('.usernum'), function (k, r) {
        userCount.push(r.value);
    })
    var levels = [];
    $.each($('.levels'), function (k, r) {
        levels.push(r.value);
    })

    var chartData = {
        labels  : levels,
        datasets: [
            {
            label               : 'Users',
            backgroundColor     : 'rgba(92, 238, 255, 0.5)',
            borderColor         : 'rgba(20, 148, 163, 0.8)',
            pointRadius         : false,
            borderWidth         : 1,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(92, 238, 255,0.8)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(92, 238, 255,0.8)',
            data                : userCount
            }
        ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#levelvsusers').get(0).getContext('2d')
    barChartData = $.extend(true, {}, chartData)
    temp0 = chartData.datasets[0]
    barChartData.datasets[0] = temp0

    var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false,
        scales: {
            yAxes: [{
                ticks: {
                    stepSize: 100,
                    suggestedMin: 0,
                    suggestedMax: 500
                }
            }]
        }
    }

    var barChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })

    var maleCount = [];
    $.each($('.males'), function (k, r) {
        maleCount.push(r.value);
    })
    var femaleCount = [];
    $.each($('.females'), function (k, r) {
        femaleCount.push(r.value);
    })
    var instList = [];
    $.each($('.inst'), function (k, r) {
        instList.push(r.value);
    })

    var chartData2 = {
        labels  : instList,
        datasets: [
            {
                label               : 'Female',
                backgroundColor     : 'rgba(255, 100, 161, 0.8)',
                borderColor         : "#FF3F8A",
                pointRadius         : false,
                borderWidth         : 1,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(255, 100, 161, 0.8)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(255, 100, 161, 0.8)',
                data                : femaleCount
            },
            {
                label               : 'Male',
                backgroundColor     : 'rgba(75, 201, 255, 0.8)',
                borderColor         : "#24B8F9",
                pointRadius         : false,
                borderWidth         : 1,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(75, 201, 255, 0.8)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(75, 201, 255, 0.8)',
                data                : maleCount
            }
        ]
    }

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas2 = $('#instvsgender').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, chartData2)
    temp0 = chartData2.datasets[0]
    var temp1 = chartData2.datasets[1]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1

    barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false,
        scales: {
            xAxes: [{
                ticks: {
                    stepSize: 10,
                    beginAtZero: true,
                }
            }]
        }
    }

    var barChart2 = new Chart(barChartCanvas2, {
        type: 'horizontalBar',
        data: barChartData,
        options: barChartOptions
    })
}