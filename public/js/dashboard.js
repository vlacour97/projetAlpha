/**
 * Created by valentinlacour on 19/11/16.
 */

var url = 'private/controller/home.php';

function initAnimations(){
    $('#geo-locations-number').each(function(){
        $(this).animateNumber({
            number: $(this).text().replace(/ /gi, ''),
            numberStep: $.animateNumber.numberStepFactories.separator(' '),
            easing: 'easeInQuad'
        }, 1000);
    });
}

function initLineStats(){

    var countries = url + '?action=lineStats';

    $.get(countries)
        .done(function(datas){
            datas = jQuery.parseJSON(datas);
            if(datas.response)
            {
                Morris.Line({
                    element: 'LineStats',
                    resize: true,
                    data: datas.content,
                    xkey: 'd',
                    ykeys: ['y'],
                    dateFormat : function(d) {
                        var date = new Date(d);
                        return date.getDate()+'/'+(date.getMonth()+1);
                    },
                    xLabelFormat: function(d){
                        return d.getDate()+'/'+(d.getMonth()+1);
                    },
                    labels: [widgetText.nbConnection],
                    lineColors: ['#88C4EE']
                });
            }
        });
}

function initDonutStatsAdmin(){
    $('#DonutStatsAdmin').css({height: 180});
    Morris.Donut({
        element: 'DonutStatsAdmin',
        data: [
            {label: widgetText.empty, value: responses.empty},
            {label: widgetText.finish, value: responses.finish},
            {label: widgetText.validate, value: responses.validate}
        ],
        colors: ['#F7653F', '#F8C0A2', '#e6e6e6']
    });

}

function initDonutStatsTE(){
    $('#DonutStatsTE').css({height: 180});
    Morris.Donut({
        element: 'DonutStatsTE',
        data: [
            {label: widgetText.empty, value: responses.empty},
            {label: widgetText.finish, value: responses.finish},
            {label: widgetText.validate, value: responses.validate}
        ],
        colors: ['#F7653F', '#F8C0A2', '#e6e6e6']
    });

}

function initWeather(){

    if($(".weather-widget").length == 0)
        return false;

    var icons = new Skycons({"color": Sing.colors['white']});
    icons.set("day0", weather_icon[0]);
    icons.play();

    icons = new Skycons({"color": Sing.colors['white']});
    icons.set("day1", weather_icon[1]);
    icons.play();

    icons = new Skycons({"color": Sing.colors['white']});
    icons.set("day2", weather_icon[2]);
    icons.play();

    icons = new Skycons({"color": Sing.lighten(Sing.colors['brand-warning'], .1)});
    icons.set("day3", weather_icon[3]);
    icons.play();

    icons = new Skycons({"color": Sing.colors['white']});
    icons.set("day4", weather_icon[4]);
    icons.play();
}

function initMap(){
    var countries = url + '?action=countries';

    $.get(countries)
        .done(function(datas){
            datas = jQuery.parseJSON(datas);
            if(datas.response)
            {
                $("#map").mapael(datas.content);
            }
        });
}


function PageLoad(){
    $('.widget').widgster();



    if(page == 'admin')
    {
        initMap();
        initLineStats();
        initDonutStatsAdmin();
    }
    if(page == 'other')
        initDonutStatsTE();
    initAnimations();
    initWeather();
}

var timer1 = setTimeout(initWeather,2000);

PageLoad();
SingApp.onPageLoad(PageLoad);