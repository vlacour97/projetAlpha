/**
 * Created by valentinlacour on 19/11/16.
 */



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
    Morris.Line({
        element: 'LineStats',
        resize: true,
        data: [
            { y: '2006', a: 100},
            { y: '2007', a: 75},
            { y: '2008', a: 50},
            { y: '2009', a: 75},
            { y: '2010', a: 50},
            { y: '2011', a: 75},
            { y: '2012', a: 10}
        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Nombre de connexions'],
        lineColors: ['#88C4EE']
    });
}

function initDonutStats(){
    $('#DonutStats').css({height: 180});
    Morris.Donut({
        element: 'DonutStats',
        data: [
            {label: "Questionnaires Vides", value: 20},
            {label: "Questionnaires Remplis", value: 12},
            {label: "Questionnaires Validés", value: 30}
        ],
        colors: ['#F7653F', '#F8C0A2', '#e6e6e6']
    });

}

function initWeather(){
    var icons = new Skycons({"color": Sing.colors['white']});
    icons.set("clear-day", "clear-day");
    icons.play();

    icons = new Skycons({"color": Sing.colors['white']});
    icons.set("partly-cloudy-day", "partly-cloudy-day");
    icons.play();

    icons = new Skycons({"color": Sing.colors['white']});
    icons.set("rain", "rain");
    icons.play();

    icons = new Skycons({"color": Sing.lighten(Sing.colors['brand-warning'], .1)});
    icons.set("clear-day-3", "clear-day");
    icons.play();

    icons = new Skycons({"color": Sing.colors['white']});
    icons.set("partly-cloudy-day-3", "partly-cloudy-day");
    icons.play();

    icons = new Skycons({"color": Sing.colors['white']});
    icons.set("clear-day-1", "clear-day");
    icons.play();

    icons = new Skycons({"color": Sing.colors['brand-success']});
    icons.set("partly-cloudy-day-1", "partly-cloudy-day");
    icons.play();

    icons = new Skycons({"color": Sing.colors['gray']});
    icons.set("clear-day-2", "clear-day");
    icons.play();

    icons = new Skycons({"color": Sing.colors['gray-light']});
    icons.set("wind-1", "wind");
    icons.play();

    icons = new Skycons({"color": Sing.colors['gray-light']});
    icons.set("rain-1", "rain");
    icons.play();
}


function PageLoad(){
    $('.widget').widgster();
    $("#map").mapael({
        map : {
            name : "world_countries"
        },
        defaultPlot: {
            attrs: {
                fill: "#fff", opacity: 0.6
            }
        },
        plots: {
            // Image plot
            'France': {
                type: "circle",
                size: 30,
                latitude:46.0000,
                longitude: 2.0000,
                attrs: {
                    opacity:.7,
                    fill: "#888"
                },
                attrsHover: {
                    transform: "s1.5"
                }
            }
        }
    });
    initLineStats();
    initDonutStats();
    initAnimations();
    initWeather();
}

var timer1 = setTimeout(initWeather,2000);

PageLoad();
SingApp.onPageLoad(PageLoad);