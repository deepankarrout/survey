"use strict";
$(function () {
    // chart1();
    // chart2();
    // chart3();
    // chart4();
    // barChart();
    $.ajax({
        url: "controllers/page/dashboard.php?type=fetchCardDetails",
        type: "GET",
        data: { survey: "CRSS" },
        contentType: false,
        processData: false,
        cache: false,
        success: function (dataResult) {
            let res = jQuery.parseJSON(dataResult);
            if (res.response == "SUCCESS") {
                let i = 1;
                res.data.forEach(element => {
                    $(`.card-${i}`).html(element.cnt);
                    i++;
                });
                console.log(res.chart);
                
                barChart(res.chart);
                // $('.card-1').html(res.data.survey_cnt);
                // $('.card-2').html(res.data.surveyor_cnt);
                // $('.card-3').html(res.data.total_qn);
            }
        },
    });

    // select all on checkbox click
    $("[data-checkboxes]").each(function () {
        var me = $(this),
            group = me.data('checkboxes'),
            role = me.data('checkbox-role');

        me.change(function () {
            var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
                checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
                dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
                total = all.length,
                checked_length = checked.length;

            if (role == 'dad') {
                if (me.is(':checked')) {
                    all.prop('checked', true);
                } else {
                    all.prop('checked', false);
                }
            } else {
                if (checked_length >= total) {
                    dad.prop('checked', true);
                } else {
                    dad.prop('checked', false);
                }
            }
        });
    });
});
function chart1() {
    var options = {
        chart: {
            height: 230,
            type: "line",
            shadow: {
                enabled: true,
                color: "#000",
                top: 18,
                left: 7,
                blur: 10,
                opacity: 1
            },
            toolbar: {
                show: false
            }
        },
        colors: ["#786BED", "#999b9c"],
        dataLabels: {
            enabled: true
        },
        stroke: {
            curve: "smooth"
        },
        series: [{
            name: "High - 2019",
            data: [5, 15, 14, 36, 32, 32]
        },
        {
            name: "Low - 2019",
            data: [7, 11, 30, 18, 25, 13]
        }
        ],
        grid: {
            borderColor: "#e7e7e7",
            row: {
                colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                opacity: 0.0
            }
        },
        markers: {
            size: 6
        },
        xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],

            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            }
        },
        yaxis: {
            title: {
                text: "Income"
            },
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            },
            min: 5,
            max: 40
        },
        legend: {
            position: "top",
            horizontalAlign: "right",
            floating: true,
            offsetY: -25,
            offsetX: -5
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart1"), options);

    chart.render();
}
function chart2() {
    var options = {
        chart: {
            height: 250,
            type: 'bar',
            stacked: true,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: true
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '200px',
            },
        },
        series: [{
            name: 'PRODUCT A',
            data: [44, 55, 41, 67, 22, 43]
        }, {
            name: 'PRODUCT B',
            data: [13, 23, 20, 8, 13, 27]
        }, {
            name: 'PRODUCT C',
            data: [11, 17, 15, 15, 21, 14]
        }],
        xaxis: {
            type: 'datetime',
            categories: ['01/01/2019 GMT', '01/02/2019 GMT', '01/03/2019 GMT', '01/04/2019 GMT', '01/05/2019 GMT', '01/06/2019 GMT'],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
        legend: {
            position: 'top',
            offsetY: 40,
            show: false,
        },
        fill: {
            opacity: 1
        },
    }

    var chart = new ApexCharts(
        document.querySelector("#chart2"),
        options
    );

    chart.render();

}
function chart3() {
    var options = {
        chart: {
            height: 250,
            type: 'line',
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            },

        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [5, 7, 5],
            curve: 'straight',
            dashArray: [0, 8, 5]
        },
        series: [{
            name: "Option 1",
            data: [45, 52, 38, 24, 33, 26, 21, 20]
        },
        {
            name: "Option 2",
            data: [35, 41, 62, 42, 13, 18, 29, 37]
        },
        {
            name: 'Option 3',
            data: [87, 57, 74, 99, 75, 38, 62, 47]
        }
        ],
        legend: {
            show: false,
        },
        markers: {
            size: 0,

            hover: {
                sizeOffset: 6
            }
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug'
            ],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
        tooltip: {

        },
        grid: {
            borderColor: '#f1f1f1',
        }
    }

    var chart = new ApexCharts(
        document.querySelector("#chart3"),
        options
    );

    chart.render();
}
function chart4() {
    var options = {
        chart: {
            height: 250,
            type: 'area',
            toolbar: {
                show: false
            },

        },
        colors: ['#999b9c', '#4CC2B0'], // line color
        fill: {
            colors: ['#999b9c', '#4CC2B0'] // fill color
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            colors: ['#999b9c', '#4CC2B0'] // marker color
        },
        series: [{
            name: 'series1',
            data: [31, 40, 28, 51, 22, 64, 80]
        }, {
            name: 'series2',
            data: [11, 32, 67, 32, 44, 52, 41]
        }],
        legend: {
            show: false,
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July'],
            labels: {
                style: {
                    colors: "#9aa0ac"
                }
            },
        },
        yaxis: {
            labels: {
                style: {
                    color: "#9aa0ac"
                }
            }
        },
    }

    var chart = new ApexCharts(
        document.querySelector("#chart4"),
        options
    );

    chart.render();

}
function barChart(jsonData) {
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    // Create chart instance
    var chart = am4core.create("barChart", am4charts.XYChart);
    chart.scrollbarX = new am4core.Scrollbar();

    // Add data
    chart.data = jsonData;

    // Create axes
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "code";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 30;
    categoryAxis.renderer.labels.template.horizontalCenter = "right";
    categoryAxis.renderer.labels.template.verticalCenter = "middle";
    categoryAxis.renderer.labels.template.rotation = 270;
    categoryAxis.tooltip.disabled = true;
    categoryAxis.renderer.minHeight = 110;
    categoryAxis.renderer.labels.template.fill = am4core.color("#9aa0ac");

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.renderer.minWidth = 50;
    valueAxis.renderer.labels.template.fill = am4core.color("#9aa0ac");

    // Create series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.sequencedInterpolation = true;
    series.dataFields.valueY = "amount";
    series.dataFields.categoryX = "code";
    series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
    series.columns.template.strokeWidth = 0;


    series.tooltip.pointerOrientation = "vertical";

    series.columns.template.column.cornerRadiusTopLeft = 10;
    series.columns.template.column.cornerRadiusTopRight = 10;
    series.columns.template.column.fillOpacity = 0.8;

    // on hover, make corner radiuses bigger
    let hoverState = series.columns.template.column.states.create("hover");
    hoverState.properties.cornerRadiusTopLeft = 0;
    hoverState.properties.cornerRadiusTopRight = 0;
    hoverState.properties.fillOpacity = 1;

    series.columns.template.adapter.add("fill", (fill, target) => {
        return chart.colors.getIndex(target.dataItem.index);
    })

    // Cursor
    chart.cursor = new am4charts.XYCursor();
}